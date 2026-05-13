<?php

namespace App\Http\Controllers;

use App\Models\SettingSite;
use App\Services\MetaConversionsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminMetaConversionsController extends AppBaseController
{
    /**
     * Show the Meta Conversions API settings page.
     */
    public function index()
    {
        $setting = SettingSite::first();
        return view('admin_meta_conversions.index', compact('setting'));
    }

    /**
     * Save Meta Conversions API settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'fb_pixel_id'       => 'nullable|string|max:50',
            'fb_access_token'   => 'nullable|string|max:500',
            'fb_test_event_code'=> 'nullable|string|max:50',
            'gtm_id'            => 'nullable|string|max:50',
            'google_ads_id'     => 'nullable|string|max:50',
        ]);

        $setting = SettingSite::first();

        if (!$setting) {
            return back()->with('error', 'لا توجد إعدادات موقع. أنشئ إعدادات الموقع أولاً.');
        }

        $setting->update([
            'fb_pixel_id'               => $request->fb_pixel_id,
            'fb_access_token'           => $request->fb_access_token,
            'fb_test_event_code'        => $request->fb_test_event_code,
            'fb_conversions_api_enabled'=> $request->boolean('fb_conversions_api_enabled'),
            'gtm_id'                    => $request->gtm_id,
            'google_ads_id'             => $request->google_ads_id,
        ]);

        return back()->with('success', '✅ تم حفظ إعدادات Meta Conversions API بنجاح.');
    }

    /**
     * Send a test PageView event to Meta CAPI to verify connection.
     */
    public function testEvent(Request $request)
    {
        $setting = SettingSite::first();

        if (empty($setting?->fb_pixel_id) || empty($setting?->fb_access_token)) {
            return response()->json([
                'success' => false,
                'message' => 'الرجاء إدخال Pixel ID و Access Token أولاً.',
            ], 422);
        }

        $payload = [
            'data' => [
                [
                    'event_name'       => 'PageView',
                    'event_time'       => time(),
                    'event_source_url' => url('/'),
                    'action_source'    => 'website',
                    'event_id'         => 'test_' . uniqid(),
                    'user_data'        => [
                        'client_ip_address' => request()->ip(),
                        'client_user_agent' => request()->userAgent(),
                    ],
                ],
            ],
        ];

        if (!empty($setting->fb_test_event_code)) {
            $payload['test_event_code'] = $setting->fb_test_event_code;
        }

        try {
            $response = Http::post(
                "https://graph.facebook.com/v19.0/{$setting->fb_pixel_id}/events?access_token={$setting->fb_access_token}",
                $payload
            );

            $json = $response->json();

            if ($response->successful() && isset($json['events_received'])) {
                return response()->json([
                    'success' => true,
                    'message' => "✅ تم الإرسال بنجاح! تم استلام {$json['events_received']} حدث.",
                    'response' => $json,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'فشل الإرسال. تحقق من الـ Access Token.',
                'response' => $json,
            ], 400);

        } catch (\Throwable $e) {
            Log::error('[MetaConversionsAPI Test] ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطأ في الاتصال: ' . $e->getMessage(),
            ], 500);
        }
    }
}

