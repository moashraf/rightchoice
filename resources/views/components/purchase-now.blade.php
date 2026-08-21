@if(!auth()->check() || !auth()->user()->isCompanyAccount())
    <div class="text-center mb-3">
        <a href="{{ route('priceBuyer', ['locale' => Config::get('app.locale')]) }}">
            <img src="{{ asset('images/1 (1).jpeg') }}" class="img-fluid" alt="اشترك الآن">
        </a>
    </div>
@endif
