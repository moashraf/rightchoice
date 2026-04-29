<x-guest-layout>
     @section('title')
تم تاكيد الهاتف    @endsection
    <x-jet-authentication-card>
        <x-slot name="logo">
         <x-logo/>
        </x-slot>

        <div class="mb-4 text-center">
            <img src="https://rightchoice-co.com/public/images/ok.jpg" width="120px" height="120px" class="mx-auto mb-4" />

            <h2 class="text-xl font-bold text-green-600 mb-2">🎉 تم التسجيل بنجاح!</h2>

            <p class="text-gray-700 text-sm mb-2">
                تم تأكيد رقم هاتفك بنجاح.
            </p>

            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4 mt-3 mb-3">
                <p class="text-yellow-800 font-semibold text-base">
                    🎁 تم إضافة <span class="text-green-600 font-bold text-lg">200 نقطة</span> مجانية إلى حسابك!
                </p>
                <p class="text-yellow-700 text-sm mt-1">
                    يمكنك استخدام هذه النقاط للاستفادة من خدمات الموقع.
                </p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3">
            <a href="{{ url(app()->getLocale() . '/') }}"
               class="flex flex-col items-center justify-center bg-blue-50 border border-blue-200 rounded-lg p-3 hover:bg-blue-100 transition">
                <span class="text-2xl mb-1">🏠</span>
                <span class="text-sm font-semibold text-blue-700">الصفحة الرئيسية</span>
            </a>
            <a href="{{ url(app()->getLocale() . '/dashboard') }}"
               class="flex flex-col items-center justify-center bg-purple-50 border border-purple-200 rounded-lg p-3 hover:bg-purple-100 transition">
                <span class="text-2xl mb-1">👤</span>
                <span class="text-sm font-semibold text-purple-700">الملف الشخصي</span>
            </a>
            <a href="{{ url(app()->getLocale() . '/all_aqar_for_sale') }}"
               class="flex flex-col items-center justify-center bg-green-50 border border-green-200 rounded-lg p-3 hover:bg-green-100 transition">
                <span class="text-2xl mb-1">🏢</span>
                <span class="text-sm font-semibold text-green-700">عقارات للبيع</span>
            </a>
            <a href="{{ url(app()->getLocale() . '/all_aqar_for_rent') }}"
               class="flex flex-col items-center justify-center bg-orange-50 border border-orange-200 rounded-lg p-3 hover:bg-orange-100 transition">
                <span class="text-2xl mb-1">🔑</span>
                <span class="text-sm font-semibold text-orange-700">عقارات للإيجار</span>
            </a>
        </div>
    </x-jet-authentication-card>

<style>
    .min-h-screen{
        text-align:center !important;
    }

</style>
</x-guest-layout>
