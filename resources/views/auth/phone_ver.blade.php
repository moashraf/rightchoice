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
                    يمكنك استخدام هذه النقاط للاستفادة من خدمات المنصة.
                </p>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-center">
                <a href="#" class="underline text-sm text-gray-600 hover:text-gray-900">
                        متابعة تسجيل الدخول
                </a>
        </div>
    </x-jet-authentication-card>

<style>
    .min-h-screen{
        text-align:center !important;
    }

</style>
</x-guest-layout>
