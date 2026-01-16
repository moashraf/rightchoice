@extends('layouts.app')
@section('title', 'Aqars')
@section('content')

<!-- Id Field -->

<div class="row col-12"> 
<ul class="list-group col-md-6">
  <li class="list-group-item" style="background-color:#343a40; color:#fff; font-weight:bold;"> Aqar Details </li>
  <li class="list-group-item">{!! Form::label('id', 'Id:') !!}   {{ $aqar->id }}</li>
  <li class="list-group-item"> {!! Form::label('slug', 'Slug:') !!}  {{ $aqar->slug }}</li></li>
  <li class="list-group-item">{!! Form::label('title', 'Title:') !!}  {{ $aqar->title }}</li>
  <li class="list-group-item">{!! Form::label('description', 'Description:') !!}  {{ $aqar->description }}</li>
    <li class="list-group-item">{!! Form::label('user_id', 'governrate :') !!}  {{$aqar->governrateq->governrate }}</li>
        <li class="list-group-item">{!! Form::label('user_id', 'property Type :') !!} {{$aqar->propertyType->property_type }}</li>

  <li class="list-group-item">{!! Form::label('number_of_floors', 'Number Of Floors:') !!}  {{ $aqar->number_of_floors }}</li>
  <li class="list-group-item">{!! Form::label('total_area', 'Total Area:') !!}  {{ $aqar->total_area }}</li>
  <li class="list-group-item">{!! Form::label('rooms', 'Rooms:') !!}  {{ $aqar->rooms }}</li>
  <li class="list-group-item">{!! Form::label('baths', 'Baths:') !!}  {{ $aqar->baths }}</li>
  <li class="list-group-item">{!! Form::label('floor', 'Floor:') !!}  {{ $aqar->floor }}</li>
  <li class="list-group-item">{!! Form::label('ground_area', 'Ground Area:') !!}  {{ $aqar->ground_area }}</li>
  <li class="list-group-item">{!! Form::label('land_area', 'Land Area:') !!}  {{ $aqar->land_area }}</li>
  <li class="list-group-item"> {!! Form::label('downpayment', 'Downpayment:') !!}  {{ $aqar->downpayment }}</li>
      <li class="list-group-item">{!! Form::label('monthly_rent', 'Monthly Rent:') !!} {{ $aqar->monthly_rent }}</li>



</ul>
<ul class="list-group col-md-6">
    <ul class="list-group ">
  <li class="list-group-item" style="background-color:#343a40; color:#fff; font-weight:bold;"> Aqar Details </li>

  <li class="list-group-item"> {!! Form::label('rent_long_time', 'Rent Long Time:') !!}  {{ $aqar->rent_long_time }}</li>
  <li class="list-group-item">{!! Form::label('offer_type', 'Offer Type:') !!}  {{ $aqar->offer_type }}</li>
  <li class="list-group-item">{!! Form::label('mtr_price', 'Mtr Price:') !!}  {{ $aqar->mtr_price }}</li>
  <li class="list-group-item">{!! Form::label('total_price', 'Total Price:') !!}  {{ $aqar->total_price }}</li>
  <li class="list-group-item">{!! Form::label('finishtype', 'Finishtype:') !!}  {{ $aqar->finishtype }}</li>
  <li class="list-group-item">{!! Form::label('area_id', 'Area Id:') !!}  {{ $aqar->area_id }}</li>
  <li class="list-group-item">{!! Form::label('views', 'Views:') !!}  {{ $aqar->views }}</li>
    <li class="list-group-item">{!! Form::label('user_id', 'aqar points :') !!}  {{$aqar->points_avail }}</li>

  <li class="list-group-item">{!! Form::label('created_at', 'Created At:') !!}  {{ $aqar->created_at }}</li>
  <li class="list-group-item">{!! Form::label('updated_at', 'Updated At:') !!}  {{ $aqar->updated_at }}</li>
  <li class="list-group-item" style="background-color:#343a40; color:#fff; font-weight:bold;"> Owner Details </li>
  <li class="list-group-item">{!! Form::label('user_id', 'User Id:') !!}  {{ $aqar->user_id }}</li> 
</ul>
 <ul class="list-group ">
  <li class="list-group-item">{!! Form::label('user_id', 'User name:') !!}  {{ $aqar->user->name }}</li>
    <li class="list-group-item">{!! Form::label('user_id', 'Email:') !!}  {{ $aqar->user->email }}</li>
  <li class="list-group-item">{!! Form::label('user_id', 'Mobile:') !!}  {{ $aqar->user->MOP }}</li>
</ul>

</ul>


<div class"col-md-12" style"margin-top:20px">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Viwer Nmae</th>
          <th scope="col">Points</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($aqar_viewers as $aqar_viewer)
            <tr>
                <td>{{ $aqar_viewer->id }}</td>
                <td><a href="https://rightchoice-co.com/admin/public/user/{{ $aqar_viewer->user->id }}/edit">{{ $aqar_viewer->user->name}}</a></td>
                <td>{{ $aqar_viewer->points }}</td>
                <td>
                    @if( $aqar_viewer->refund == 1 )
                        <span data-toggle="modal" data-target="#change_aqar_status_modal">
                            <button type="button"
                                    data-placement="top"
                                    data-toggle="tooltip"
                                    title="ارجاع النقاط"
                                    data-url="{{ route('admin.refund_points', $aqar_viewer->id) }}"
                                    id="change_aqar_status_btn"
                                    class="btn btn-raised btn-icon btn-danger mr-1">
                                ارجاع النقاط
                            </button>
                        </span>
                    @else
                        <button type="button"
                                class="btn btn-raised btn-icon btn-secondary mr-1">
                                تم ارجاع النقاط 
                        </button>
                    @endif
                </td
            </tr>
        @empty
            <tr>
                <td></td>
                <td colspan="2" class="text-center">لا يوجد بيانات</td>
                <td></td>
            </tr>
        @endforelse
      </tbody>
    </table>
    
    {{ $aqar_viewers->links() }}
</div>

<div class="modal fade" id="change_aqar_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="" id="change_aqar_status_form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> ارجاع النقاط </h5>
                </div>
                <div class="modal-body">
                    <p>هل انت متاكد من ارجاع النقاط</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-danger">ارجاع</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('page_scripts')
    <script>
        $(document).on('click', "#change_aqar_status_btn", function () {
            $("#change_aqar_status_form").attr('action', $(this).data('url'));
        })    
    </script>
@endpush


