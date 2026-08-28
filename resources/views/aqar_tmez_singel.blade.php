<x-layout>
 @section('title')
{{    $PriceVip->name   }}
@endsection

    <div   class="  text-center">
        <div style="height: 100%;">
                        <br> <br>

            <span>{{   $PriceVip->name }}</span>
            <br> <br>
            @if(!empty($promotionDiscountPercent))
                <span style="display:inline-block; padding:5px 11px; border-radius:999px; color:#fff; background:#0b66bd; font-weight:900;">
                    خصم {{ $promotionDiscountPercent }}%
                </span>
                <br><br>
            @endif
            <h1 style="display: inline; font-weight:bold;" class="pr-value   ">{{ number_format((float) $PriceVip->price, 2) }}</h1><span>ج.م</span>
            <br>
                <p> {{  $PriceVip->name }} </p>
                 <br>

            @if ($errors->any())
                <div class="alert alert-danger" style="max-width:520px;margin:0 auto 20px;">
                    {{ $errors->first() }}
                </div>
            @endif

    <section id="register" class="bg-light text-center">
        <div class="container">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-bank-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-bank" type="button" role="tab" aria-controls="pills-bank"
                        aria-selected="true">الدفع عن طريق البنك</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-fawry-tab" data-bs-toggle="pill" data-bs-target="#pills-fawry"
                        type="button" role="tab" aria-controls="pills-fawry" aria-selected="false">الدفع عن طريق فوري</a>
                </li>


            </ul>
            <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade" id="pills-fawry" role="tabpanel" aria-labelledby="pills-fawry-tab">
                    <div class="row">
                        <div class="col-lg-6">
                            @auth
                                <p>ادفع من أي منفذ فوري بعد الحصول على الرقم المرجعي.</p>
                                <form action="{{ route('vip-fawry-checkout', ['locale' => Config::get('app.locale')]) }}" method="POST">
                            @csrf
                            <input  TYPE="hidden" NAME="price_id" value="{{ $PriceVip->id }}">
                            <input  TYPE="hidden" NAME="aqar_id" value="{{ $aqarSingle_id }}">
                                <div class="form-group" style="text-align: center; align-items:center;">
                                        <input type="submit" class="btn btn-theme-light rounded" name="submit" id="" value="اشترك الان">
                                    </div>
                            </form>
                            @else
                                <div class="alert alert-warning">
                                    <p>يجب تسجيل الدخول أولاً لتمييز الإعلان</p>
                                    <a href="{{ URL::to(Config::get('app.locale').'/login') }}" class="btn btn-theme-light rounded">تسجيل الدخول</a>
                                </div>
                            @endauth
                         <img src="{{ url('public/images/icons/fawry.jpg') }}" class="img-thumbnail" loading="lazy" />


                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="pills-bank" role="tabpanel"
                    aria-labelledby="pills-bank-tab">
                    <div class="row">
                        <div class="col-lg-6">
                <div class=" ">
@php
    $fawryIsStaging = config('services.fawry.env') !== 'production';
    $fawryPluginCss = $fawryIsStaging
        ? config('services.fawry.staging.plugin_css')
        : config('services.fawry.plugin_css');
    $fawryPluginJs = $fawryIsStaging
        ? config('services.fawry.staging.plugin_js')
        : config('services.fawry.plugin_js');
@endphp
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="{{ $fawryPluginCss }}">
<script src="{{ $fawryPluginJs }}"></script>

@auth
    <p>أدخل بيانات الفيزا في نافذة فوري الآمنة. بيانات البطاقة لا تمر على سيرفر الموقع.</p>
    @if($fawryIsStaging)
        <div class="alert alert-info" style="text-align:right; max-width:520px; margin: 0 auto 16px;">
            بيئة تجربة فوري (Staging). بطاقة نجاح: <code>4242424242424242</code>
            — CVV <code>100</code> — الانتهاء حسب بيانات فوري <code>05/25</code>.
        </div>
    @endif
	<button type="button" class="btn btn-theme-light rounded" onclick="checkout()" alt="pay-using-fawry" id="fawry-payment-btn">     ادفع بالفيزا </button>
	   <br> <br>
	<div id="fawry-UAT"></div>
	<script>
function checkout() {
    const btn = document.getElementById('fawry-payment-btn');
    if (btn) {
        btn.disabled = true;
        btn.textContent = 'جاري فتح نافذة الدفع...';
    }

    fetch("{{ route('vip-card-checkout', ['locale' => Config::get('app.locale')]) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            price_id: {{ (int) $PriceVip->id }},
            aqar_id: {{ (int) $aqarSingle_id }}
        })
    })
    .then(function (response) {
        return response.text().then(function (text) {
            var data = {};
            try { data = text ? JSON.parse(text) : {}; } catch (e) { data = {}; }
            return { ok: response.ok, data: data };
        });
    })
    .then(function (result) {
        if (!result.ok || !result.data || !result.data.chargeRequest) {
            throw new Error((result.data && result.data.message) ? result.data.message : 'تعذر بدء عملية الدفع بالفيزا');
        }

        const chargeRequest = result.data.chargeRequest;
        if (chargeRequest.chargeItems) {
            chargeRequest.chargeItems.forEach(function (item) {
                item.price = parseFloat(item.price);
            });
        }

        FawryPay.checkout(chargeRequest, {
            locale: "ar",
            divSelector: 'fawry-UAT',
            mode: DISPLAY_MODE.POPUP,
            onSuccess: successCallBack,
            onFailure: failureCallBack
        });
    })
    .catch(function (error) {
        alert(error.message || 'تعذر الاتصال بخدمة الدفع');
        if (btn) {
            btn.disabled = false;
            btn.textContent = 'ادفع بالفيزا';
        }
    });
}

function successCallBack(data) {
    const params = new URLSearchParams({
        orderStatus: (data && data.orderStatus) || 'PAID',
        referenceNumber: (data && data.referenceNumber) || '',
        merchantRefNumber: (data && (data.merchantRefNumber || data.merchantRefNum)) || '',
        customerProfileId: (data && data.customerProfileId) || '',
        paymentAmount: (data && data.paymentAmount) || ''
    });
    window.location.href = "{{ url(Config::get('app.locale') . '/tmyezz_fawryCallback') }}?" + params.toString();
}

function failureCallBack(data) {
    alert("فشل الدفع - حاول مرة اخرى");
    document.getElementById('fawryPayPaymentFrame')?.remove();
    const btn = document.getElementById('fawry-payment-btn');
    if (btn) {
        btn.disabled = false;
        btn.textContent = 'ادفع بالفيزا';
    }
}
		</script>
@else
	<div class="alert alert-warning">
		<p>يجب تسجيل الدخول أولاً لتمييز الإعلان</p>
		<a href="{{ URL::to(Config::get('app.locale').'/login') }}" class="btn btn-theme-light rounded">تسجيل الدخول</a>
	</div>
@endauth



                        </div>
                                         <img src="{{ url('public/images/icons/download.png') }}" class="img-thumbnail" loading="lazy" />


                      </div>
                    </div>

                </div>
            </div>
        </div>
    </section>



                           <br> <br>







</div>
    </div>


</x-layout>
