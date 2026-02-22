<x-guest-layout>
     @section('title')
    تاكيد البريد الالكتروني
    @endsection
    <x-jet-authentication-card>
        <x-slot name="logo">
         <x-logo/>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
                    {{ trans('langsite.verficationverfication')}}
            {{ $user->MOP  }}
        </div>
                 <form method="POST" action="{{ route('verficationApply') }}">
                @csrf

                <input type="hidden" name="userID" value="{{ $user->id }}" />
                    <div>
                        <x-jet-input type="text" name="otb"/>
                    </div>
                <div>
                    <br>
                    <x-jet-button type="submit">
                                {{ trans('langsite.submit')}}
                    </x-jet-button>
                </div>
            </form>

        <div class="mt-4 flex items-center justify-between">


            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ trans('langsite.logout')}}
                </button>
            </form>
             <form method="POST" action="{{ route('resendOTB') }}">
                @csrf
                        <input type="hidden" name="userID" value="{{ $user->id }}" />
                        <input type="hidden" name="MOP" value="{{ $user->MOP }}" />
                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    اعاده ارسال الكود
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
