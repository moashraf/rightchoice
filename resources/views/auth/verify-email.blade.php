<x-guest-layout>
     @section('title')
    تاكيد البريد الالكتروني
    @endsection
    <x-jet-authentication-card>
        <x-slot name="logo">
         <x-logo/>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
           {{ trans('langsite.verfication_msg')}}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
               {{ trans('langsite.verfication_button')}}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit">
                        {{ __('Resend Verification Email') }}
                    </x-jet-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ trans('langsite.logout')}}
                </button>
            </form>
        </div>
    </x-jet-authentication-card>

<style>
    .min-h-screen{
        text-align:center !important;
    }
    
</style>
</x-guest-layout>
