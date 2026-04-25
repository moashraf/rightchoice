<x-layout>
 @section('title')
        {{ trans('langsite.my_ads')}}
    @endsection
<?PHP
$user = auth()->user();

if(isset($user) ){ }else{ dd("يجب تسجيل الدخول ");  }

 ?>

<section id="profile-info" class="bg-light">

                <div class="container">

                    <div class="main-body">
                      <div class="row gutters-sm">


                            <div class="col-md-8">



                           @foreach ($allAqars as $aqar)
                           @if($aqar != null)
                                <div class="col-lg-12">
                                    <div class="card mt-3">
                                        <div class="row no-gutters">


                                          <div class="col-sm-5 col-card-imgs">
                                                <div class="click">

                                                        <div><a href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqar->slug) }}">


                                                                                    @if($aqar->mainImage)
                                 <img src="{{ URL::to('/').'/images/'.$aqar->mainImage->img_url}}"  class="img-fluid main-img" alt="main">

                                @else



                                                            @if($aqar->firstImage)
                                                            <img
                                                                    src="{{ URL::to('/') . '/images/' . $aqar->firstImage->img_url }}"
                                                                    class="img-fluid mx-auto" alt="" />


                                                                             	@else
                                        <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"    alt="main">


                                                                    @endif
                                                                    @endif



                                                                    </a></div>




                                                </div>
                                                        <div class="views">

                        <div class="views-2 views-2-user_ads " >
                            <i class="fa fa-eye"></i>
                            <span>{{ $aqar->views }}</span>

                        </div>
                    </div>
                                            </div>
                                            <div class="col-sm-7 order-lg-first col-card-details">
                                                <div class="card-body">
                                                    <div class="listing-detail-wrapper">
                                                        <div class="listing-short-detail-wrap flex-block">
                                                            <div class="listing-short-detail">
                                                                <h4 dir="rtl" class="listing-name verified"><a href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqar->slug) }}">

                                                                        {{ \Illuminate\Support\Str::limit($aqar->title, 50) }}
                                                                    </a></h4>
                                                                <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->



                                                            </div>
                                                            @if ($aqar->status == 0)
                                                                 <div>

                                                                      <a  href="#" class="btn btn-outline-warning">جاري المراجعه</a>

                                                                </div>
                                                                @endif
                                                            @if ($aqar->status == 1)
                                                                 <div>

                                                                      <a  href="#" class="btn btn-outline-success">

                                                                        تم نشر الاعلان
                                                                        </a>

                                                                </div>
                                                                @endif

                                                                @if($aqar->status != 0 && $aqar->status != 1)
                                                                    <div>

                                                                      <a  href="#" class="btn btn-outline-danger">

                                                                        تم رفض الاعلان
                                                                        </a>

                                                                </div>
                                                            @endif



                                                        </div>
                                                        <div class="listing-short-detail-flex">
                                                            <h6 class="listing-card-info-price2">
                                                                @if ($aqar->offerTypes->id == 1 || $aqar->offerTypes->id == 2 )
                                                                {{ $aqar->total_price }}
                                                                @endif
                                                                @if ($aqar->offerTypes->id == 3 || $aqar->offerTypes->id == 4 )
                                                                {{ $aqar->monthly_rent }}
                                                                @endif  جنيه مصري
                                                            </h6>
                                                        </div>
                                                    </div>

                                                    <div class="">
                                                        <div class="list-fx-features2" >
                                                            <div class="listing-card-info-icon">
                                                            {{ $aqar->baths }} حمام
                                                                <div class="inc-fleat-icon"><img
                                                                        src="{{ asset('images/icons/bath.png') }}" width="13"
                                                                        alt="" />
                                                                </div>
                                                            </div>
                                                                <div class="listing-card-info-icon">
                                                                {{ $aqar->rooms }} غرف
                                                                    <div class="inc-fleat-icon"><img
                                                                            src="{{ asset('images/icons/room.png') }}" width="13" alt="" />
                                                                    </div>
                                                                </div>

                                                            <div class="listing-card-info-icon">
                                                            {{ $aqar->total_area }} م²
                                                                <div class="inc-fleat-icon"><img
                                                                        src="{{ asset('images/icons/area.png') }}" width="13" alt="" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                          <div class="foot-location mb-2">

                                                           @if ($aqar->governrateq)
                                                                        {{ $aqar->governrateq->governrate }}
                                                                    @endif,
                                                                     @if ($aqar->districte)
                                                                    {{ $aqar->districte->district }}
                                                                    @endif
                                                                    @if ($aqar->subAreaa)
                                                                    {{ $aqar->subAreaa->area }}
                                                                    @endif
                                                                    <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" />
                                                        </div>

                                                    <div class="btnAdds">
                                                        <a type="button" class="btn btn-outline-danger removeFromAds  ml-2" data-id="{{$aqar['id']}}"> حذف</a>


                                                        <a  href="{{ URL::to(Config::get('app.locale').'/aqars/update/'.$aqar->slug ) }}" class="btn btn-outline-dark ml-2">تعديل</a>

                                                       @if($aqar->vip === 19999999999)
                                                        <a  href="{{ URL::to(Config::get('app.locale').'/pricing-vip/'.$aqar->id ) }}" class="btn btn-outline-success ml-2">تمييز</a>
                                                        @else
                                                      <!--
                                                      <a disabled class="btn btn-success ml-2">تم التمييز</a>
                                                                !-->
                                                                @endif

                                                        <a   target="_blank"  href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqar->slug) }}"  class="btn btn-outline-primary ml-2">عرض</a>

                                                        {{-- زر إظهار المستخدمين المهتمين --}}
                                                        <button type="button"
                                                                class="btn btn-outline-info ml-2 toggle-interested"
                                                                data-target="#interested-{{ $aqar->id }}">
                                                            <i class="fas fa-users"></i>
                                                            المهتمون
                                                            <span class="badge badge-light">{{ $aqar->interested_contacts_count ?? 0 }}</span>
                                                        </button>

                                                        <!-- <a class="btn btn-light  ml-2 addToCart" data-id="{{$aqar['id']}}"> أضف <svg-->
                                                        <!--    xmlns="http://www.w3.org/2000/svg" width="16"-->
                                                        <!--    height="16" fill="currentColor" class="bi bi-heart"-->
                                                        <!--    viewBox="0 0 16 16">-->
                                                        <!--    <path-->
                                                        <!--        d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />-->
                                                        <!--</svg></a>-->

                                                    </div>

                                                    {{-- ── لوحة المستخدمين المهتمين (مخفية افتراضياً) ── --}}
                                                    <div id="interested-{{ $aqar->id }}"
                                                         class="interested-panel mt-3"
                                                         style="display:none; background:#f8f9fa; border:1px solid #e3e6f0; border-radius:8px; padding:12px;">
                                                        <h6 class="mb-3" style="border-bottom:1px solid #e3e6f0; padding-bottom:8px;">
                                                            <i class="fas fa-user-friends text-info"></i>
                                                            المستخدمون المهتمون بهذا العقار
                                                        </h6>

                                                        @php
                                                            $contacts = $aqar->interestedContacts->unique('user_id')->filter(fn($c) => $c->user);
                                                        @endphp

                                                        @if($contacts->isEmpty())
                                                            <div class="text-muted text-center p-2">
                                                                <i class="fas fa-info-circle"></i>
                                                                لا يوجد مستخدمون مهتمون حتى الآن.
                                                            </div>
                                                        @else
                                                            <div class="row">
                                                                @foreach($contacts as $contact)
                                                                    @php $u = $contact->user; @endphp
                                                                    <div class="col-md-6 mb-2">
                                                                        <div style="display:flex; align-items:center; gap:10px; background:#fff; padding:10px; border-radius:8px; border:1px solid #eee;">
                                                                            @if($u->profile_image)
                                                                                <img src="{{ URL::to('/').'/images/'.$u->profile_image }}"
                                                                                     alt="{{ $u->name }}"
                                                                                     style="width:50px; height:50px; border-radius:50%; object-fit:cover; border:2px solid #f1f1f1;"
                                                                                     loading="lazy"
                                                                                     >
                                                                            @else
                                                                                <img src="{{ asset('images/FBO.png') }}"
                                                                                     alt="{{ $u->name }}"
                                                                                     style="width:50px; height:50px; border-radius:50%; object-fit:cover; border:2px solid #f1f1f1;"
                                                                                     loading="lazy"
                                                                                     >
                                                                            @endif
                                                                            <div style="flex:1; min-width:0;">
                                                                                <div style="font-weight:bold; font-size:14px;">
                                                                                    {{ $u->name ?? '—' }}
                                                                                </div>
                                                                                @if($u->email)
                                                                                    <div style="font-size:12px; color:#666; word-break:break-all;">
                                                                                        <i class="fas fa-envelope"></i>
                                                                                        <a href="mailto:{{ $u->email }}">{{ $u->email }}</a>
                                                                                    </div>
                                                                                @endif
                                                                                @if($u->MOP)
                                                                                    <div style="font-size:12px; color:#666;">
                                                                                        <i class="fas fa-phone"></i>
                                                                                        <a href="tel:{{ $u->MOP }}">{{ $u->MOP }}</a>
                                                                                    </div>
                                                                                @endif
                                                                                <div style="font-size:11px; color:#999;">
                                                                                    {{ $contact->created_at ? $contact->created_at->format('Y-m-d H:i') : '' }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @else
      <div class="col-lg-12">
                                    <div class="card mt-3" style="margin: 0 0px;">
                                        <div class="row no-gutters">


                                            <div class="col-sm-5 col-card-imgs">
                                                <div class="click">

                                                        <div>
                                                             <img style=" object-fit: contain;"
                                                                  src="https://rightchoice-co.com/assets/img/rclogo.png"
                                                                    class="img-fluid mx-auto" alt="" />
                                                                      </div>




                                                </div>


                                            </div>
                                            <div class="col-sm-7 order-lg-first col-card-details">
                                                <div class="card-body">
                                                    <div class="listing-detail-wrapper">
                                                        <div class="listing-short-detail-wrap flex-block">
                                                            <div class="listing-short-detail">
                                                                <h4  class="listing-name verified"><a href="#" target="_blank">
       </a></h4>
                                                                <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->



                                                            </div>

                                                                    <div>


                                                                </div>
                                                        </div>
                                                        <div class="listing-short-detail-flex">
                                                            <h6 class="listing-card-info-price2">
                                                          </h6>
                                                        </div>

                                                    </div>

                                                    <div class="list-rap">
                                                        <div class="list-fx-features2" >
                                                            <div class="listing-card-info-icon">
 <h3></br></br>
     تم مسح العقار
 </h3>
                                                            </div>



                                                        </div>
                                                    </div>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                        @endif
                            @endforeach

                            {{ $allAqars->links() }}




                            </div>
                          @include('components.profile-sidebar')

                      </div>



                        </div>

                    </div>




            </section>


		<!-- ============================ Call To Action ================================== -->
								<x-call-to-action />
		<!-- ============================ Call To Action End ================================== -->

<script>
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.toggle-interested');
        if (!btn) return;
        e.preventDefault();
        var sel = btn.getAttribute('data-target');
        var box = document.querySelector(sel);
        if (!box) return;
        var isOpen = box.style.display !== 'none' && box.style.display !== '';
        box.style.display = isOpen ? 'none' : 'block';
        btn.classList.toggle('active', !isOpen);
    });
</script>

</x-layout>
