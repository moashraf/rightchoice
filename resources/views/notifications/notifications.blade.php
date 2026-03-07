<x-layout>

    @section('title')
        التنبيهات
    @endsection
    <?PHP
    $user = auth()->user();

    if (isset($user)) {
    } else {
        dd("يجب تسجيل الدخول ");
    }

    ?>

    <section id="profile-info" class="bg-light">

        <div class="container">

            <div class="main-body">


                <div class="row gutters-sm">


                    <div class="col-md-8 mt-3">

                        @if(!empty($notifications))
                            @foreach($notifications as $not)
                                <div id="notifi-{{ $not->id }}"
                                     class="rounded alert notifi_div  {{ !$not->status ? 'alert-success':'card' }}">
                                    <div class="accordion" id="accordionExample">

                                        <div class="accordion-item ">

                                            <button class="accordion-button ChangeStatusNotfi" type="button"
                                                    data-bs-toggle="collapse" data-id="{{$not->id}}"
                                                    data-bs-target="#collapseOne-{{$not->id}}" aria-expanded="true"
                                                    aria-controls="collapseOne" onclick="updateStatus({{ $not->id }})">

                                                <h5> {{ $not->title }}</h5>

                                            </button>

                                            <div id="collapseOne-{{$not->id}}"
                                                 class="accordion-collapse collapse notificationBody"
                                                 aria-labelledby="headingOne" data-bs-parent="#accordionExample">

                                                {!! $not->message !!}

                                            </div>

                                        </div>


                                    </div>
                                </div>
                            @endforeach

                            {{ $notifications->links() }}
                        @endif

                    </div>

                    <?php if (Auth()->user()->TYPE != 4) { ?>
                    @include('components.profile-sidebar')

                    <?php }else{ ?>
                    <div class="col-md-4">
                        <x-vertical-adv/>

                    </div>
                    <?php } ?>


                </div>


            </div>

        </div>


    </section>


    <!-- ============================ Call To Action ================================== -->
    <x-call-to-action/>
    <!-- ============================ Call To Action End ================================== -->

</x-layout>
