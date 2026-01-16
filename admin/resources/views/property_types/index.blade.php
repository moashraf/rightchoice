@extends('layouts.app')
@section('title', 'Property Type')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>أنواع الخواص</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('propertyTypes.create') }}">
                        اضافه جديد
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        @include('components.filter_search',['route_name' => 'propertyTypes.index'])
        <div class="card">
            <div class="card-body p-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Property Type</th>
                                <th>Category</th>
                                <th>حدث</th>
                            </tr>
                            <!--end tr-->
                            </thead>

                            <tbody>
                            @foreach($property_types as $property_type)
                                <tr>
                                    <td>{{$property_type->id}}</td>
                                    <td>{{$property_type->property_type}}</td>
                                    <td>{{$property_type->category->category_name}}</td>
                                    <td>@include('property_types.datatables_actions',['id'=>$property_type->id])</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix float-right">
                        <div class="float-right">
                            {{$property_types->links()}}

                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix float-right">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

