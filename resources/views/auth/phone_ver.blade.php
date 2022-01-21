<x-guest-layout>
     @section('title')
تم تاكيد الهاتف    @endsection
    <x-jet-authentication-card>
        <x-slot name="logo">
         <x-logo/>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
           Phone number has been succesfully verified
        </div>
            
            <img src="https://rightchoice-co.com/public/images/ok.jpg" width="120px" height="120px" />
            

        <div class="mt-4 flex items-center justify-between">
            
```

                <a href="{{ Route('/') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                        Continue to login
                </a>
        </div>
    </x-jet-authentication-card>

<style>
    .min-h-screen{
        text-align:center !important;
    }
    
</style>
</x-guest-layout>
