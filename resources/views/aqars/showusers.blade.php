@extends('layouts.app')
@section('title', 'Edit Aqar')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تحرير عقار</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <!-- @include('adminlte-templates::common.errors') -->
        @include('flash::message')

        <div class="card">

            {!! Form::model($aqar, ['route' => ['aqars.update', $aqar->id],'files' => true, 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('aqars.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('aqars.index') }}" class="btn btn-default">الغاء</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@section('footerScript')
<script>
    $(window).on("load", function () {
        var max_fields = 1; //maximum input boxes allowed
        var wrapper = $(".imagesmore"); //Fields wrapper
        var add_button = $(".addimg"); //Add button ID

        var x = 0; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment

                $(wrapper).append(
                    '<div class="row card-header mb-3">' +
                    '<div class="col-sm-6">' +
                    '<div class="form-line">' +
                    '<label class="font-bold">(Select More Image)Size(512*613)</label>' +
                    '<input type="file" name="images[]" class="form-control" multiple>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-2 mt-4">' +
                    '<button " class="btn btn-danger btn-flat btn-icon-only remove_field">  <i class="far fa-trash-alt"></i> </button>' +
                    '</div>'+
                    '</div>'

                ); //add input box
            }
        });
        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            var remo = $(this).parent().parent().hide('slow')
                .remove();
            x--;
        })
    });

</script>
<script>
    $(document).ready(function() {
        $('#selecttested').select2({
            closeOnSelect:false
        });
        $("#chkall").click(function(){
                if($("#chkall").is(':checked')){
                    $("#selecttested > option").prop("selected", "selected");
                    $("#selecttested").trigger("change");
                } else {

                    $("#selecttested").val(null).trigger('change');
                }
        });
    });
</script>
<script>
        $(document).ready(function()
        {
            var cheackus = $("select[name='user_id']").val();
            // alert(cancel);
            $("select[name='user_id']").change(function() {
                if($(this).val() >= 1) {
                    $("#user_phonediv").show(2000);
                    $("#user_name").removeClass("form-group col-sm-12").addClass("form-group col-sm-4");
                } else {
                    $("#user_phonediv").hide(2000);
                    $("#user_name").removeClass("form-group col-sm-4").addClass("form-group col-sm-12");
                }
            });
            if(cheackus > 0){

                $("#user_phonediv").show(2000);
                $("#user_name").removeClass("form-group col-sm-12").addClass("form-group col-sm-4");
            }else{
                $("#user_phonediv").hide(2000);
                $("#user_name").removeClass("form-group col-sm-4").addClass("form-group col-sm-12");
            }

        });
</script>

<script>
        $(document).ready(function()
        {
            var cheackus = $("select[name='reciving']").val();
            // alert(cancel);
            $("select[name='reciving']").change(function() {
                if($(this).val() == 1) {
                    $("#rec_time").show(2000);
                } else {
                    $("#rec_time").hide(2000);
                }
            });
            if(cheackus == 1){
                $("#rec_time").show(2000);
            }else{
                $("#rec_time").hide(2000);
            }

        });
</script>

<script>
        $(window).on("load", function () {
            var cheacktype = $("select[name='property_type']").val();

            $("select[name='property_type']").change(function() {
                if($(this).val() == 1) {
                    $("#number_of_floors").hide(2000);
                    $("#floor").show(2000);
                    $("#rooms").show(2000);
                    $("#baths").show(2000);
                    $("#finishtype").show(2000);
                    $("#license_type").hide(2000);

                } else if($(this).val() == 2){
                    $("#number_of_floors").hide(2000);
                    $("#floor").hide(2000);
                    $("#rooms").hide(2000);
                    $("#baths").hide(2000);
                    $("#finishtype").show(2000);
                    $("#license_type").hide(2000);

                } else if($(this).val() == 7 || $(this).val() == 20 || $(this).val() == 21 || $(this).val() == 23){
                    $("#number_of_floors").show(2000);
                    $("#finishtype").show(2000);
                    $("#floor").hide(2000);
                    $("#rooms").hide(2000);
                    $("#baths").hide(2000);
                    $("#license_type").hide(2000);
                } else if($(this).val() == 9){
                    $("#license_type").show(2000);
                    $("#floor").hide(2000);
                    $("#rooms").hide(2000);
                    $("#baths").hide(2000);
                    $("#finishtype").hide(2000);
                    $("#number_of_floors").hide(2000);
                } else {
                    $("#floor").show(2000);
                    $("#rooms").show(2000);
                    $("#baths").show(2000);
                    $("#finishtype").show(2000);
                    $("#license_type").hide(2000);
                    $("#number_of_floors").hide(2000);
                }
            });
            if(cheacktype == 1) {
                $("#number_of_floors").hide(2000);
                $("#floor").show(2000);
                $("#rooms").show(2000);
                $("#baths").show(2000);
                $("#finishtype").show(2000);
                $("#license_type").hide(2000);
            } else if(cheacktype == 2){
                $("#number_of_floors").hide(2000);
                $("#floor").hide(2000);
                $("#rooms").hide(2000);
                $("#baths").hide(2000);
                $("#finishtype").show(2000);
                $("#license_type").hide(2000);
            } else if(cheacktype == 7 || cheacktype == 20 || cheacktype == 21 || cheacktype == 23){
                $("#number_of_floors").show(2000);
                $("#finishtype").show(2000);
                $("#floor").hide(2000);
                $("#rooms").hide(2000);
                $("#baths").hide(2000);
                $("#license_type").hide(2000);

             } else if(cheacktype == 9){
                $("#license_type").show(2000);
                $("#floor").hide(2000);
                $("#rooms").hide(2000);
                $("#baths").hide(2000);
                $("#finishtype").hide(2000);
                $("#number_of_floors").hide(2000);
            } else {
                $("#floor").show(2000);
                $("#rooms").show(2000);
                $("#baths").show(2000);
                $("#finishtype").show(2000);
                $("#license_type").hide(2000);
                $("#number_of_floors").hide(2000);

            }

        });
</script>
<script>
        $(window).on("load", function () {
            var cheackus = $("select[name='offer_type']").val();
            var cheacktype = $("select[name='property_type']").val();
            // alert(cancel);
            $("select[name='offer_type']").change(function() {
                if($(this).val() == 2) {
                    $("#installment_downpayment").show(2000);
                    $("#installment_time").show(2000);
                    $("#installment_reciving").show(2000);
                    $("#finannce_bank").show(2000);
                    $("#licensed").show(2000);
                    $("#trade").show(2000);
                    $("#total_price").show(2000);
                    $("#monthly_rent").hide(2000);

                } else if($(this).val() == 1) {
                    $("#installment_downpayment").hide(2000);
                    $("#installment_time").hide(2000);
                    $("#installment_reciving").hide(2000);
                    $("#finannce_bank").show(2000);
                    $("#licensed").show(2000);
                    $("#trade").show(2000);
                    $("#total_price").show(2000);
                    $("#monthly_rent").hide(2000);

                } else if(($(this).val() == 3 || $(this).val() == 4)) {
                    $("#monthly_rent").show(2000);
                    $("#installment_downpayment").hide(2000);
                    $("#installment_time").hide(2000);
                    $("#installment_reciving").hide(2000);
                    $("#finannce_bank").hide(2000);
                    $("#licensed").hide(2000);
                    $("#trade").hide(2000);
                    $("#total_price").hide(2000);
                } else {
                    $("#installment_downpayment").hide(2000);
                    $("#installment_time").hide(2000);
                    $("#installment_reciving").hide(2000);
                    $("#finannce_bank").hide(2000);
                    $("#licensed").hide(2000);
                    $("#trade").hide(2000);
                    $("#finannce_bank").hide(2000);
                    $("#licensed").hide(2000);
                    $("#trade").hide(2000);
                    $("#monthly_rent").hide(2000);
                    $("#total_price").show(2000);
                }
            });
            if(cheackus == 2) {
                $("#installment_downpayment").show(2000);
                $("#installment_time").show(2000);
                $("#installment_reciving").show(2000);
                $("#finannce_bank").show(2000);
                $("#licensed").show(2000);
                $("#trade").show(2000);
                $("#total_price").show(2000);
                $("#monthly_rent").hide(2000);

            } else if(cheackus == 1) {
                    $("#installment_downpayment").hide(2000);
                    $("#installment_time").hide(2000);
                    $("#installment_reciving").hide(2000);
                    $("#finannce_bank").show(2000);
                    $("#licensed").show(2000);
                    $("#trade").show(2000);
                    $("#total_price").show(2000);
                    $("#monthly_rent").hide(2000);


            } else if((cheackus == 3 || cheackus == 4)) {
                $("#monthly_rent").show(2000);
                $("#installment_downpayment").hide(2000);
                $("#installment_time").hide(2000);
                $("#installment_reciving").hide(2000);
                $("#finannce_bank").hide(2000);
                $("#licensed").hide(2000);
                $("#trade").hide(2000);
                $("#total_price").hide(2000);
            } else {
                $("#installment_downpayment").hide(2000);
                $("#installment_time").hide(2000);
                $("#installment_reciving").hide(2000);
                $("#finannce_bank").hide(2000);
                $("#licensed").hide(2000);
                $("#trade").hide(2000);
                $("#monthly_rent").hide(2000);
                $("#total_price").show(2000);
            }

        });
</script>

<script type="text/javascript">
        $("select[name='category']").change(function () {
            var category = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "<?php echo Url('ajax-getpropertyByCat') ?>",
                method: 'POST',
                data: {
                    category: category,
                    _token: token
                },
                success: function (data) {
                    var myCities = $('select[name="property_type"]');
                      myCities.find('option').remove();
                    if (data.status != 401) {
                        // myCities.append('<option value="">-- Select --</option>');
                        $.each(data.data, function (key, val) {
                            myCities.append('<option value="' + val.id + '">' + val.property_type + '</option>');
                        });
                    } else {
                        myCities.append('<option value="">-- No Data Fetch --</option>');
                        // myCities.prop('disabled', true);
                    }
                }
            });
        });
</script>

<script type="text/javascript">
        $("select[name='governrate_id']").change(function () {
            var governrate_id = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "<?php echo Url('ajax-getdistrictByGovernrate') ?>",
                method: 'POST',
                data: {
                    governrate_id: governrate_id,
                    _token: token
                },
                success: function (data) {
                    var myCities = $('select[name="district_id"]');
                      myCities.find('option').remove();
                    if (data.status != 401) {
                        // myCities.append('<option value="">-- Select --</option>');
                        $.each(data.data, function (key, val) {
                            myCities.append('<option value="' + val.id + '">' + val.district + '</option>');
                        });
                    } else {
                        myCities.append('<option value="">-- No Data Fetch --</option>');
                        // myCities.prop('disabled', true);
                    }
                }
            });
        });
</script>
<script type="text/javascript">
        $("select[name='user_id']").change(function () {
            var user_id = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "<?php echo Url('ajax-getPhoneUser') ?>",
                method: 'POST',
                data: {
                    user_id: user_id,
                    _token: token
                },
                success: function (data) {
                    var myCities = $('input[name="user_phone"]');
                    $('.user_phone').val('');
                    if (data.status != 401) {
                        $.each(data.data, function (key, val) {
                            $('.user_phone').val(val.MOP);
                        });
                    } else {
                        myCities.append('value="No Data Fetch"');
                        // myCities.prop('disabled', true);
                    }
                }
            });
        });
</script>
@endsection
@endsection
