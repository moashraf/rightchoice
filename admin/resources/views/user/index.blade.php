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
                    <h1>المستخدمون</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('user.create') }}">
                        اضف جديد
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')


        <div class="card">

            <form action="{{route('user.index')}}" class="container justify-content-center m-3 row align-items-end">
                <div class="row justify-content-center m-2">
                    <div class="col-md-3">
                        <label>
                            بحث
                            <input type="text" class="form-control" name="search_key"
                                   placeholder="بحث ... " value="{{request('search_key')}}">
                        </label>
                    </div>
                    <div class="row col-md-3 align-items-center">
                        <div class="col-md-6">
                            <label>
                                اظهار
                                <select name="show" class="form-control">
                                    <option value="10">10</option>
                                    <option value="25" {{25 == request('show')? 'selected' : ""}}>25</option>
                                    <option value="50" {{50 == request(   'show')? 'selected' : ""}}>50</option>
                                    <option value="100" {{100 == request('show')? 'selected' : ""}}>100</option>
                                </select>
                            </label>
                        </div>

                    </div>
                </div>
                <div class="col-md-2 m-2">
                    <label>الحالة</label>
                    <select class="form-control" name="filter_status">
                        <option value="">اختر</option>

                        @foreach(\App\Enums\UserStatusEnum::values() as $key => $case)
                            <option
                                value="{{$case}}" {{request('filter_status') !=null ? (request('filter_status') == $case?'selected':'') : ''}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 m-2">
                    <label>النوع</label>
                    <select class="form-control" name="filter_type">
                        <option value="">اختر</option>
                        @foreach(\App\Enums\UserTypeEnum::values() as $key => $case)
                            <option
                                value="{{$case}}" {{request('filter_type')!=null ? (request('filter_type') == $case?'selected':''):''}}>{{$key}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 m-2">
                    <label>ترتيب حسب</label>
                    <select class="form-control" name="sortBy">
                        <option value="">اختر</option>
                        <option value="0" {{request('sortBy')!=null ?( request('sortBy') == 0? 'selected' : ''): '' }}>
                            من الاحدث للاقدم
                        </option>
                        <option value="1" {{request('sortBy')!=null ?( request('sortBy') == 1? 'selected' : ''): '' }}>
                            من الاقدم للاحدث
                        </option>
                    </select>
                </div>

                <div class="row justify-content-center">
                    <button class="btn btn-success col-md-2">
                        <i class="fa fa-filter"></i>
                    </button>
                </div>
            </form>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>اسم</th>
                            <th>نوع</th>
                            <th>الباقة</th>
                            <th>البريد الإلكتروني</th>
                            <th>التليفون المحمول</th>
                          
                                                      <th>التاريخ</th>

                            <th>حالة</th>
                            <th>حدث</th>
                        </tr>
                        <!--end tr-->
                        </thead>

                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->getUserType()}}</td>
                               
                                <td>
                                
                                    @foreach($user->UserPriceing as $val)
                                    {{$val->type}} 
                                    @endforeach
                                    
                                </td>
                               
                                   
                                <td>{{$user->email}}</td>
                                <td>{{$user->MOP}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    @php
                                        if($user->status == 1){
                                           $status = '<span class="badge badge-success">'.$user->getStatus().'</span>';
                                       }elseif($user->status == 0){
                                           $status = '<span class="badge badge-warning">'.$user->getStatus().'</span>';
                                       }else{
                                           $status = '<span class="badge badge-danger">'.$user->getStatus().'</span>';
                                       }
                                    @endphp
                                    {!! $status !!}
                                </td>
                                <td>
                                    @php
                                        $all  = '<!--<a data-toggle="tooltip" data-skin-class="tooltip-primary"  data-placement="top" title = "Show User Profile" href = "' . url('/users/' . $user->id) . '"   class="btn btn-sm btn-outline-primary"><i class="fas fa-user"></i></a>--> ';
                                       if ($user->status == 1) {
                                           $all .= '<a onClick="return confirm(\'Are You Sure You Want To Block This Users?\')" data-toggle="tooltip" data-skin-class="tooltip-danger"  data-placement="top" title = "Block User" href="' . url('/users/' . $user->id . '/block') . '"  class="btn btn-sm btn-outline-danger ml-2"><i class="fas fa-times"></i></a>';
                                       } else {

                                           $all .= '<a onClick="return confirm(\'Are You Sure You Want To Active This User ?\')" data-toggle="tooltip" data-skin-class="tooltip-danger" data-placement="top" title = "Active User"  href="' . url('/users/' . $user->id . '/activate') . '"  class="btn btn-sm btn-outline-success ml-2"><i class="fas fa-check"></i></a>';
                                       }
                                       $all .= '<a onClick="return confirm(\'Are You Sure You Want To Delete This Record ?  \')" data-toggle="tooltip" data-skin-class="tooltip-danger"  data-placement="top" title = "Delete" href = "' . url('/users/' . $user->id . '/delete'). '"  class="btn btn-sm btn-outline-danger ml-2" style="margin-left:5px"><i class="fas fa-trash"></i></a>';
                                       $all .= '<a     href = "' . url('/user/' . $user->id . '/edit'). '"  class="btn btn-sm btn-outline-edit   ml-2" style="margin-left:5px"><i class="fas fa-edit  "></i></a>';
                                       $all .= '<a     href = "' . url('/user/' . $user->id . '/show'). '"  class="btn btn-sm btn-outline-eye   ml-2" style="margin-left:5px"><i class="fas fa-eye  "></i></a>';
                                    @endphp
                                    {!! $all !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        {{$users->appends(request()->query())->links()}}

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

