# Mobile social authentication and FCM

Implementation branch: `7-9-2026`. Laravel 10 / Sanctum 3.

## Dependency and deployment gate

The editing environment has no PHP or Composer. Dependency resolution, the lock file
update, PHP execution, and device tests have NOT been completed. Do not deploy this
branch with the old lock file. On a development machine matching the server's PHP
version, run the following and commit the resulting composer.lock before deployment:

```bash
composer update google/apiclient firebase/php-jwt kreait/laravel-firebase doctrine/dbal --with-all-dependencies
composer validate --strict
php artisan config:clear
vendor/bin/phpunit -c phpunit.mobile.xml --testsuite Google
vendor/bin/phpunit -c phpunit.mobile.xml --testsuite Apple
vendor/bin/phpunit -c phpunit.mobile.xml --testsuite FCM
```

Stop at any failing slice, fix it, and rerun that slice before advancing. The isolated
suite uses an in-memory SQLite schema because the repository does not contain the
legacy SQL schema/migrations. It exercises the new migrations, real Apple RSA/JWK
verification with local keys, controller flows with mocked provider verification,
Sanctum token creation, device ownership and FCM failure handling. It does not prove
Google/Apple configuration or delivery on a physical phone.

`doctrine/dbal` is required for Laravel 10's column `change()` on the test database.
Firebase integration is constrained to the Laravel 10-compatible 5.x package line.
The supplied users structure confirms unsigned bigint IDs, nullable MOP/email and
varchar(255) password. Existing data and the user's package creation hook are preserved.
Social users start as active personal accounts; phone verification remains unset/false.
Passwords stay nullable when rolling back, because social accounts have no old password.

After testing, deploy normally using the updated lock file. Back up the database and run:

```bash
php artisan migrate --path=database/migrations/2026_09_08_000001_add_social_identity_to_users.php
php artisan migrate --path=database/migrations/2026_09_08_000002_create_fcm_tokens_table.php
php artisan config:cache
```

## Server configuration

Copy these values from `.env.example` into the server's private `.env`:

```dotenv
GOOGLE_WEB_CLIENT_ID=15346110767-7fq20pf3cof6ahb1p8gm3ki0g9og69d0.apps.googleusercontent.com
APPLE_CLIENT_ID=com.rightchoiceco.app
FIREBASE_CREDENTIALS=/absolute/private/path/service-account.json
```

Download the service account JSON from Firebase Console > Project Settings > Service
Accounts, keep it outside Git and the public web root, readable only by the application
runtime. Kreait's automatically discovered provider reads FIREBASE_CREDENTIALS.
No Firebase key is included in this branch.

## API contract

Send `Accept: application/json` and `Content-Type: application/json`.

`POST /api/auth/social`

```json
{"provider":"google","token":"GOOGLE_ID_TOKEN"}
```

For native Apple sign-in, use `provider: apple` and the Apple identity token. Optional
`name` is display-only profile input on initial sign-in; Apple does not put the user's
full name in the identity token. Store/send it on first consent. Subsequent sign-ins
preserve the profile. Request the email scope; a verified provider email is required
for initial registration. Do not send an OAuth access token or a Firebase Auth ID token.

Success follows the existing API envelope: `data.token`, `data.token_type`, `data.user`.
Use the token as `Authorization: Bearer <data.token>` for protected requests.

- 401: invalid signature, issuer, audience, or expiry.
- 403: inactive, blocked, or soft-deleted account.
- 409: email already belongs to an existing account, or concurrent creation conflict.
  Use the existing login method; automatic email-based linking is deliberately disabled.
- 422: invalid request or no verified provider email at first registration.
- 503: missing client configuration or provider network failure.

A given provider/sub identifies the account. A user with another provider or a password
account is not silently linked. Client-supplied email, role, status or user_id are not
used for account creation. Public social identity fields are not mass assignable.

`POST /api/fcm-token` (Sanctum required): `{"token":"DEVICE_FCM_TOKEN"}`.
A token has one owner; registering it again updates its owner to the authenticated user.
Refresh/re-register on token refresh, login and account switching. Multiple devices per
user are supported. `DELETE /api/fcm-token` with the same body removes only a token owned
by the authenticated user. Call DELETE before logout/revoking the bearer token so the
logged-out device does not continue receiving notifications.

## Sending from Laravel

From an authorized server-side caller:

```php
$result = app(\App\Services\FcmNotificationService::class)->sendToUser(
    \App\Models\User::findOrFail($userId),
    'RightChoice',
    'Test notification',
    ['screen' => 'notifications']
);
```

Data values must be strings. No public push-send endpoint is exposed. The service
returns sent/removed counts, removes only tokens explicitly reported UNREGISTERED,
and propagates other errors for the caller to retry/handle. It does not wire pushes
into unrelated existing notification events or perform automatic retries.

## Physical-device acceptance slices

1. Android Google: configure Android package and signing certificate fingerprints in
   Google/Firebase, use the supplied web client ID as the server audience, request an
   ID token, call auth/social, then call a protected API with the returned bearer.
   Repeat login and verify the same user and no duplicate welcome package.
2. Real iPhone Apple: enable Sign in with Apple for `com.rightchoiceco.app`, request
   name/email, test first consent, repeat login and Hide My Email; verify the same user.
3. FCM: configure Firebase in each mobile app, request notification permission, obtain
   and register its FCM token. Configure APNs credentials/capability in Firebase for iOS.
   Send a test from Firebase Console, then send via the Laravel service. Verify foreground,
   background, and terminated-app behavior and notification tap navigation. The mobile
   app must implement foreground display and tap/deep-link handling; Laravel cannot do this.
   Finally test token refresh, account switch, DELETE before logout, and stale-token cleanup.

Record device, OS, build, response status and notification outcomes. These checks are
pending; no actual notification has been sent from this implementation session.

References: [Google ID-token verification](https://developers.google.com/identity/gsi/web/guides/verify-google-id-token),
[Laravel Firebase compatibility](https://github.com/beste/laravel-firebase/blob/5.10.0/composer.json),
[FCM error codes](https://firebase.google.com/docs/reference/admin/error-handling).
