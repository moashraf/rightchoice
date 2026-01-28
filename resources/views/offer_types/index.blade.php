@extends('layouts.app')
@section('title', 'Offer Type')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>أنواع العروض</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('offerTypes.create') }}">
                        اضف جديد
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        @include('components.filter_search',['route_name' => 'offerTypes.index'])

        <div class="card">
            <div class="card-body p-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>نوع العرض</th>
                                <th>slug</th>
                                <th>أنشئت في</th>
                                <th>حدث</th>
                            </tr>
                            <!--end tr-->
                            </thead>

                            <tbody>
                            @foreach($offer_types as $offer_type)
                                <tr>
                                    <td>{{$offer_type->id}}</td>
                                    <td>{{$offer_type->type_offer}}</td>
                                    <td>{{$offer_type->slug}}</td>
                                    <td>{{$offer_type->created_at}}</td>
                                    <td>@include('offer_types.datatables_actions',['id'=>$offer_type->id])</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix float-right">
                        <div class="float-right">
                            {{$offer_types->links()}}

                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        <div class="card">


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

