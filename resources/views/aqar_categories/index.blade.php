@extends('layouts.app')
@section('title', 'Aqar Category')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>فئات عقار</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('aqarCategories.create') }}">
                        اضف جديد
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        @include('components.filter_search',['route_name' => 'aqarCategories.index'])

        <div class="card">
            <div class="card-body p-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>الاسم</th>
                                <th>حدث</th>
                            </tr>
                            <!--end tr-->
                            </thead>

                            <tbody>
                            @foreach($aqar_categories as $aqar_category)
                                <tr>
                                    <td>{{$aqar_category->id}}</td>
                                    <td>{{$aqar_category->category_name}}</td>
                                    <td>@include('aqar_categories.datatables_actions',['id'=>$aqar_category->id])</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix float-right">
                        <div class="float-right">
                            {{$aqar_categories->links()}}

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

