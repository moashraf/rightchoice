@extends('layouts.app')
@section('title', 'Complaints')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>شكاوي</h1>
                </div>
                <!-- <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('complaints.create') }}">
                        Add New
                    </a>
                </div> -->
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Aqar Name</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                            <!--end tr-->
                            </thead>

                            <tbody>
                            @foreach($complaints as $val)
                                <tr>
                                    <td>{{$val->id}}</td>
                                    <td>
                                        @if($val->userinfo)
                                            <a target="_blank" href="{{route('complaintsUser',$val->userinfo->id)}}">{{$val->userinfo->name}}</a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                   <td>
                                       @if($val->aqars_id)
                                           <a target="_blank" href="{{route('aqars.show',$val->aqars_id)}}">{{$val->message}}</a>
                                       @else
                                           {{$val->message}}
                                       @endif
                                   </td>
                                    <td>{{$val->created_at->format('Y-m-d H:i')}}</td>
                                    <td>@include('complaints.datatables_actions',['id'=>$val->id])</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix float-right">
                        <div class="float-right">
                            {{$complaints->links()}}

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

