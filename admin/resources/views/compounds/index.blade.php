@extends('layouts.app')
@section('title', 'Compounds')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>مجمعات سكنية</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('compounds.create') }}">
                        اضف جديد
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        @include('components.filter_search',['route_name' => 'compounds.index'])

        <div class="card">
            <div class="card-body p-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>اسم المجمع</th>
                                <th>حدث</th>
                            </tr>
                            <!--end tr-->
                            </thead>

                            <tbody>
                            @foreach($compounds as $compound)
                                <tr>
                                    <td>{{$compound->id}}</td>
                                    <td>{{$compound->compound}}</td>
                                    <td>@include('compounds.datatables_actions',['id'=>$compound->id])</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix float-right">
                        <div class="float-right">
                            {{$compounds->links()}}

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

