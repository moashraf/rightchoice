<x-layout>
 @section('title')
    شكرا لك
@endsection

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <section id="thank-page">
        <div class="text-center container">
            <h1 class="display-3">!شكرا لك</h1>
             <hr>


            <h3 style=" line-height: 41px;">
                {{ session('success') }}</h3>
            <br>

            <p>
              لديك مشكله ؟
              <a href="{{ url(Config::get('app.locale').'/contact-us') }}">
                 تواصل معنا
              </a>
            </p>
            <p class="lead">
                @if(session('id'))
              <a class="btn btn-light btn-sm" style="padding:10px"
                 href="{{ url(Config::get('app.locale').'/pricing-vip/'.session('id')) }}" role="button">
                  ميز اعلانك</a>
                @endif

            </p>
          </div>
    </section>


    <x-call-to-action />

</x-layout>
