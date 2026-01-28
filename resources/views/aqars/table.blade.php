@extends('layouts.app')
@section('title', 'Aqars')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Aqars</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('aqars.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">

                <!-- DataTables -->
                <link href="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet"
                      type="text/css"/>
                <link href="{{ URL::asset('plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet"
                      type="text/css"/>
                <!-- Responsive datatable examples -->
                <link href="{{ URL::asset('plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet"
                      type="text/css"/>

                <form action="{{route('aqars.index')}}" class="container m-3 row align-items-end">
                    <div class="col-md-2 m-2">
                        <label>الحالة</label>
                        <select class="form-control" name="filter_status">
                            <option value="">اختر</option>

                            @foreach(\App\Enums\StatusEnum::values() as $key => $case)
                                <option value="{{$case}}" {{request('filter_status') !=null ? (request('filter_status') == $case?'selected':'') : ''}}>{{$key}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 m-2">
                        <label>تمييز</label>
                        <select class="form-control" name="filter_vip">
                            <option value="" >اختر</option>
                            @foreach(\App\Enums\VIPEnum::values() as $key => $case)
                                <option value="{{$case}}" {{request('filter_vip')!=null ? (request('filter_vip') == $case?'selected':''):''}}>{{$key}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 m-2">
                        <label>ترتيب حسب</label>
                        <select class="form-control" name="sortBy">
                            <option value="">اختر</option>
                            <option value="0" {{request('sortBy')!=null ?( request('sortBy') == 0? 'selected' : ''): '' }}>من الاحدث للاقدم</option>
                            <option value="1" {{request('sortBy')!=null ?( request('sortBy') == 1? 'selected' : ''): '' }}>من الاقدم للاحدث</option>
                        </select>
                    </div>
                    <div class="col-md-3 mx-1">
                        <label>بحث
                            <input
                                type="search" name="key_word" class="form-control" placeholder=""
                                aria-controls="datatable" value="{{request('key_word')}}"></label>
                    </div>

                    <div class="row justify-content-center">
                            <button class="btn btn-success col-md-2">
                                <i class="fa fa-filter"></i>
                            </button>
                    </div>
                </form>


                <div class="content px-3">

                    @include('flash::message')

                    <div class="clearfix"></div>

                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="datatable" class="table">
                                    <div class="col-sm-12 col-md-6">
                                        <div id="" class=""></div>
                                    </div>
                                    <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>الاسم</th>
                                        <th>محافظه</th>
                                        <th>نوع الوحده</th>
                                        <th>التمييز</th>
                                        <th>الحاله</th>
                                        <th>اسم المالك</th>
                                        <th> المشاهدات</th>
                                        <th>تاريخ الاضافه</th>
                                        <th>التنفيذ</th>

                                    </tr>
                                    <!--end tr-->
                                    </thead>

                                    <tbody>

                                    @foreach($allAqars as $allAqars_val)
                                        <tr>
                                            <td> {{ $allAqars_val->id }} </td>
                                            <td>   <?php echo \Illuminate\Support\Str::limit($allAqars_val->title, 30, ''); ?> </td>
                                            <td> {{ $allAqars_val->governrateq->governrate }} </td>
                                            <td> {{ $allAqars_val->propertyType->property_type}} </td>
                                            <td> {{ $allAqars_val->getVIP() }} </td>
                                            <td> {{$allAqars_val->getStatus() }} </td>

                                            <td>
                                                <a href="https://rightchoice-co.com/admin/public/user/{{ $allAqars_val->user->id }}/edit">   {{ $allAqars_val->user->name }}  </a>
                                            </td>
                                            <td> {{ $allAqars_val->views }} </td>

                                            <td>   <?php echo date_format($allAqars_val->created_at, "Y/m/d  "); ?> </td>
                                            <td>
                                            {!! Form::open(['route' => ['aqars.destroy', $allAqars_val->id], 'method' => 'delete']) !!}
                                            <div class="btn-group gap-2">
                                                <a href="{!! route('aqars.show', [$allAqars_val->id]) !!}" class="btn btn-info font-18">
                                                    <i class="fas fa-eye"></i>
                                                </a>                                                
                                                
                                                <a href="{!! route('aqars.edit', [$allAqars_val->id]) !!}" class="btn btn-primary font-18">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            
                                                {!! Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger font-18', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                            </div>
                                        
                                            {!! Form::close() !!}
                                        </td>


                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix float-right">
                                <div class="float-right">
                                    <?php echo $allAqars->appends(request()->query())->links(); ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
                <script src="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>


                <div class="card-footer clearfix float-right">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection


