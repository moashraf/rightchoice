@extends('layouts.app')

@section('title', 'Users')
@section('headerStyle')

    <!-- DataTables -->
    <link href="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>

@stop

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>التفاصيل</h1>
                </div>

            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        @include('components.filter_search',['route_name' => 'user.index'])
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead class="thead-light">
                        <tr>
                            <th>العقار</th>
                            <th>النقط</th>
                            <th>السبب</th>
                            <th>التاريخ</th>
                            <th>الحدث</th>
                        </tr>
                        <!--end tr-->
                        </thead>

                        <tbody>
                        @foreach($aqars_views as $view)
                            <tr>
                                <th>{{$view->title}}</th>
                                <th>{{$view->aqar->title}}</th>
                                <th>{{$view->}}</th>
                                <th>{{$view}}</th>
                                <th><a class="btn btn-danger">استرجاع</a></th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix float-right">
                    <div class="float-right">


                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@section('footerScript')
    <script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>

@endsection

