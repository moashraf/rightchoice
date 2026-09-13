<x-layout>
    @section('title', 'إضافة رقم الهاتف')

    <div class="container" style="padding-top: 70px; padding-bottom: 70px;">
    <x-jet-authentication-card>
        <x-slot name="logo"><x-logo /></x-slot>

        <div dir="rtl" class="text-right">
            <h2 class="mb-3 text-xl font-bold">أضف رقم هاتفك</h2>
            <p class="mb-4 text-sm text-gray-600">
                يلزم إضافة رقم هاتف موثّق قبل إضافة عقار أو الاشتراك في أي باقة.
            </p>

            @if (session('success'))
                <div class="mb-4 text-sm text-green-600">{{ session('success') }}</div>
            @endif

            @if (!$pendingPhone)
                <form method="POST" action="{{ route('phone.request-otp', ['locale' => app()->getLocale()]) }}">
                    @csrf
                    <label for="phone" class="block mb-1">رقم الهاتف</label>
                    <x-jet-input id="phone" name="phone" type="tel" inputmode="numeric"
                        value="{{ old('phone', auth()->user()->MOP) }}"
                        placeholder="01XXXXXXXXX" required autofocus />
                    @error('phone')<div class="mt-2 text-sm text-red-600">{{ $message }}</div>@enderror

                    <div class="mt-4">
                        <x-jet-button type="submit">إرسال رمز التحقق</x-jet-button>
                    </div>
                </form>
            @else
                <p class="mb-4 text-sm text-gray-600">
                    تم إرسال رمز التحقق إلى {{ $pendingPhone }}
                </p>
                <form method="POST" action="{{ route('phone.verify', ['locale' => app()->getLocale()]) }}">
                    @csrf
                    <label for="otp" class="block mb-1">رمز التحقق</label>
                    <x-jet-input id="otp" name="otp" type="text" inputmode="numeric"
                        maxlength="4" autocomplete="one-time-code" required />
                    @error('otp')<div class="mt-2 text-sm text-red-600">{{ $message }}</div>@enderror

                    <div class="mt-4">
                        <x-jet-button type="submit">تأكيد وحفظ رقم الهاتف</x-jet-button>
                    </div>
                </form>
            @endif
        </div>
    </x-jet-authentication-card>
    </div>
</x-layout>
