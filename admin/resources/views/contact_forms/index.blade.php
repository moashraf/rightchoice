@extends('layouts.app')
@section('title', 'Contact Forms')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>نماذج الاتصال</h1>
                </div>
                <!-- <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('contactForms.create') }}">
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
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>الاسم</th>
                                <th>الهاتف</th>
                                <th>البريد الالكترونى</th>
                                <th>العنوان</th>
                                <th>التاريخ</th>
                                <th>حدث</th>
                            </tr>
                            <!--end tr-->
                            </thead>

                            <tbody>
                            @foreach($contact_form as $offer_type)
                                <tr>
                                    <td>{{$offer_type->id}}</td>
                                    <td>{{$offer_type->name}}</td>
                                    <td>{{$offer_type->phone}}</td>
                                    <td>{{$offer_type->email}}</td>
                                    <td>{{$offer_type->subject}}</td>
                                    <td>{{$offer_type->created_at->format('Y-m-d H:i')}}</td>

                                    <td>@include('contact_forms.datatables_actions',['id'=>$offer_type->id])</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix float-right">
                        <div class="float-right">
                            {{$contact_form->links()}}

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
    </div>

@endsection

