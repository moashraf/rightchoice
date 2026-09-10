<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\User;
use App\Services\Auth\SocialTokenVerifier;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;
use DomainException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use UnexpectedValueException;

class SocialAuthController extends AppBaseController
{
    public function handle(Request $request, SocialTokenVerifier $verifier): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'provider' => ['bail', 'required', 'string', 'in:google,apple'],
            'token' => ['bail', 'required', 'string', 'max:16384'],
            // Apple supplies the display name separately on the first consent only.
            'name' => ['bail', 'nullable', 'string', 'max:90'],
        ], [
            'provider.required' => 'The provider field is required.',
            'provider.string' => 'The provider must be a string.',
            'provider.in' => 'The provider must be either google or apple.',
            'token.required' => 'The provider token field is required.',
            'token.string' => 'The provider token must be a string.',
            'token.max' => 'The provider token must not exceed 16384 characters.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 90 characters.',
        ]);

        if ($validator->fails()) {
            return $this->sendError(
                'Validation failed.',
                422,
                $validator->errors()->toArray()
            );
        }

        $data = $validator->validated();

        try {
            $claims = $verifier->verify($data['provider'], $data['token']);
        } catch (UnexpectedValueException | InvalidArgumentException | DomainException $e) {
            return $this->sendError('Invalid or expired identity token.', 401);
        } catch (ConnectionException | RequestException | GuzzleException $e) {
            return $this->sendError('Identity provider is temporarily unavailable. Please retry.', 503);
        }

        try {
            return DB::transaction(function () use ($data, $claims) {
                $user = User::withTrashed()->where('provider', $data['provider'])
                    ->where('provider_id', $claims['sub'])->lockForUpdate()->first();

                if ($user && ($user->trashed() || (int) $user->status !== 1)) {
                    return $this->sendError('Your account is inactive', 403);
                }

                if (!$user) {
                    $email = $claims['email'] ?? null;
                    if (!is_string($email) || strlen($email) > 90
                        || !filter_var($email, FILTER_VALIDATE_EMAIL)
                        || !in_array($claims['email_verified'] ?? null, [true, 'true', 1, '1'], true)) {
                        return $this->sendError('A verified provider email is required for the first sign-in.', 422);
                    }

                    // Do not silently attach a new provider to an existing account.
                    if (User::withTrashed()->where('email', $email)->exists()) {
                        return $this->sendError('An account already uses this email. Sign in using its existing method.', 409);
                    }

                    $user = new User();
                    $user->provider = $data['provider'];
                    $user->provider_id = $claims['sub'];
                    $name = $claims['name'] ?? ($data['name'] ?? 'RightChoice user');
                    $user->name = Str::limit(is_string($name) && trim($name) !== '' ? trim($name) : 'RightChoice user', 90, '');
                    $user->email = $email;
                    $user->email_verified_at = now();
                    $user->password = null;
                    $user->TYPE = 1;
                    $user->isAdmin = 0;
                    $user->status = 1;
                    // Email verification is not phone verification.
                    $user->phone_verfied_sms_status = 0;
                    $user->save();
                }

                // Preserve profile data on subsequent sign-ins (Apple omits name).
                return $this->sendResponse([
                    'token' => $user->createToken('mobile')->plainTextToken,
                    'token_type' => 'Bearer',
                    'user' => [
                        'id' => $user->id, 'name' => $user->name, 'email' => $user->email,
                        'phone' => $user->MOP, 'type' => $user->TYPE,
                        'isAdmin' => $user->isAdmin, 'status' => $user->status,
                    ],
                ], 'User logged in successfully');
            });
        } catch (QueryException $e) {
            if (in_array($e->errorInfo[1] ?? null, [1062, 19], true) || $e->getCode() === '23505') {
                return $this->sendError('Account creation conflicted with another request. Please sign in again.', 409);
            }
            throw $e;
        }
    }
}
