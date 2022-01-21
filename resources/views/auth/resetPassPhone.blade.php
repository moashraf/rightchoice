<x-guest-layout >
     @section('title')
            طلب كلمه مرور جديده
    @endsection
    <x-jet-authentication-card>
         <x-slot name="logo">
         <x-logo/>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('phoneResetPassword') }}">
            @csrf


            <div class="block">
                <x-jet-label for="phone" value="الهاتف" />
                <x-jet-input id="email" class="block mt-1 w-full" type="text" name="phone" value="{{ $userPhone }}" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="كلمه المرور" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="اعد كتابه كلمه المرور" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                تعديل كلمه المرور
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
    <style>
        body{
            direction:rtl;
        }
    </style>
</x-guest-layout>
