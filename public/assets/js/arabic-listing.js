
$(function () {
	"use strict";





$('.content-2').hide();
$('.content-3').hide();

$('#form-1').submit(function (e) {
     let valid = true;

    // التحقق من المحافظه
    if (!$('#governrate_id').val()) {
        $('#governrate_btn').addClass('gov-invalid');
        $('#governrate_error').show();
        valid = false;
    } else {
        $('#governrate_btn').removeClass('gov-invalid');
        $('#governrate_error').hide();
    }

    // التحقق من الحي
    if (!$('#district_id').val()) {
        $('#district_btn').addClass('gov-invalid');
        $('#district_error').show();
        valid = false;
    } else {
        $('#district_btn').removeClass('gov-invalid');
        $('#district_error').hide();
    }

    if (!valid) {
        e.preventDefault();
        // scroll الى أول حقل فاضي
        var firstInvalid = $('.gov-invalid').first();
        if (firstInvalid.length) {
            $('html, body').animate({
                scrollTop: firstInvalid.offset().top - 150
            }, 300);
        }
        return false;
    }

	e.preventDefault();
	var x = $("#form-1").serializeArray();
	$("#result-form-1").empty();

	$.each(x, function(i, field){
		$("#result-form-1").append(`<input name="${field.name}" value="${field.value}" />`);
	  });

	$('.content-1').hide();
	$('.content-2').show();
	$('.content-3').hide();
	$("html, body").animate({scrollTop: 0}, 1000);

});


$('#form-2').submit(function (e) {

	e.preventDefault();
	var y = $("#form-2").serializeArray();
	$("#result-form-2").empty();
	$.each(y, function(i, field){
		$("#result-form-2").append(`<input name="${field.name}" value="${field.value}" />`);
	  });

	$('.content-1').hide();
	$('.content-2').hide();
	$('.content-3').show();
	$("html, body").animate({scrollTop: 0}, 1000);

});
$('#back-form-1').on('click', function (e) {
	e.preventDefault();
	$('.content-1').show();
	$('.content-2').hide();
	$('.content-3').hide();
	$("html, body").animate({scrollTop: 0}, 1000);

});
$('#back-form-2').on('click', function (e) {
	e.preventDefault();
	$('.content-1').hide();
	$('.content-2').show();
	$('.content-3').hide();
	$("html, body").animate({scrollTop: 0}, 1000);

});
// Select mzaya
$('#mzaya').select2({
	placeholder: "اهم المزايا",
	allowClear: true,
	closeOnSelect:false
}).on('select2:selecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
.on('select2:select', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')));



$('#li-cat').on('change', function () {
	if ($(this).val() == "2") {
		$('#Property-type').html(`
		<option  selected disabled  value="">اختر نوع العقار</option>
		<option value="12">محلات</option>
		<option value="13">حضانات</option>
		<option value="14">مخازن</option>
		<option value="15">كافيهات</option>
		<option value="16">مولات</option>
		<option value="17">صيدليه</option>
		<option value="18">معرض</option>
		<option value="19">مطاعم</option>
 		<option value="20">مدارس</option>
		<option value="21">مصانع</option>
				<option value="24">عيادات</option>


		`);
		$('#floor-div').hide();
		$('select[name="floor"]').attr('required', true);


	} else if ($(this).val() == "3") {
		$('#Property-type').html(`
		<option   selected disabled value="">اختر نوع العقار</option>
		<option value="1">شقه</option>
		<option value="7">عمارات</option>
		<option value="24">عيادات</option>
		<option value="13">دور كامل</option>0
		`);
		$('#floor-div').show();
		$('#floor-div select').prop('required',true);

	} else {
		$('#Property-type').html(`
		<option   selected disabled value="">اختر نوع العقار</option>
		<option value="1">شقه</option>
		<option value="2">فلل خاصه</option>
		<option value="3">روف</option>
		<option value="4">استديو</option>
		<option value="5">شاليهات</option>
		<option value="6">غرف مشاركه</option>
		<option value="7">عمارات</option>
<option value="8">فلل دوبلكس</option>
<option value="9">اراضي</option>
		<option value="10">توين هاوس</option>
		<option value="11">بنتاهاوس</option>
		`);
		$('#floor-div').show();
		$('select[name="floor"]').attr('required', true);

	}
});
$('#installment-div').hide();


/*
$('#Property-type').on('change', function () {
  	if ($(this).val() == 7 || $(this).val() == 9 || $(this).val() == 17 || $(this).val() == 21 || $(this).val() == 22) {

  	    $('#inner-floor').hide();
  	    $('#inner-floor input').attr('required', false);
  	}
  	else{

  	      // alert($(this).val() );
  	     $('#inner-floor').show();
  	    $('#inner-floor input').attr('required', true);
  	}
});

*/

$('#offer-type').on('change', function () {


	if ($(this).val() == 2) {

	/*	$('#installment-div').show();
		$('#installment-div input').prop('required',true);
		$('#boolean-row').show();
		$('select[name="trade"]').attr('required', true);

 		$('select[name="finannce_bank"]').attr('required', true);
		$('select[name="licensed"]').attr('required', true);
		$('#total-price-div').show();
		$('#total-price-div input').prop('required',true);
		$('#rent-div').hide();*/
		$('#showHide').html(`
		  <div id="boolean-row" class="row" style="align-content: start;
                            justify-content: start;">

                                <!-- bank-finance -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="bank-finance">تصلح تمويل عقاري <span
                                                class="text-danger">*</span></label>
                                        <select required oninvalid="this.setCustomValidity('من فضلك اختر احدى الاختيارات')"
                         oninput="this.setCustomValidity('')" name="finannce_bank" id="bank-finance" class="myselect">
                                            <option  selected disabled   value="">اختر</option>
                                            <option  value="1" >نعم
                                            </option>
                                            <option value="0" >كلا
                                            </option>
                                        </select>

                                    </div>
                                </div>

                                <!-- trade -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="trade">تصلح للبدل <span class="text-danger">*</span></label>
                                        <select required oninvalid="this.setCustomValidity('من فضلك اختر احدى الاختيارات')"
  oninput="this.setCustomValidity('')" name="trade" id="trade" class="myselect">
                                            <option   selected disabled  value="">اختر</option>
                                            <option value="1" >نعم</option>
                                            <option value="0">كلا</option>
                                        </select>

                                    </div>
                                </div>
                                <!-- signed -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="signed">مسجله شهر عقاري <span class="text-danger">*</span></label>
                                        <select required oninvalid="this.setCustomValidity('من فضلك اختر احد الاختيارات')"
  oninput="this.setCustomValidity('')" name="licensed" id="signed" class="myselect">
                                            <option   selected disabled  value="">اختر</option>
                                            <option value="1" >نعم
                                            </option>
                                            <option value="0" >كلا
                                            </option>
                                        </select>

                                    </div>
                                </div>
                            </div>
	     <div class="col-lg-3" id="total-price-div">
                                <div class="form-group">
                                    <label for="total-price">السعر الاجمالي <span class="text-danger">*</span></label>
                                    <input required  oninvalid="this.setCustomValidity('من فضلك ادخل السعر الاجمالي ')"
  oninput="this.setCustomValidity('')" type="number" name="total_price" id="total-price" class="myselect"
                                        placeholder="" min="50">

                                </div>
                            </div>
		                <div id="installment-div" class="row" style="align-content: start;
                            justify-content: start;">
                                <!-- mtr price -->
                                <!-- <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="mtr-price">سعر المتر</label>
                                        <input required type="number" name="mtr_price" id="mtr-price" class="myselect"
                                            placeholder="500 L.E" min="0" >

                                    </div>
                                </div>-->
                                <!-- down payment -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="down-payment">المقدم <span class="text-danger">*</span></label>
                                        <input required oninvalid="this.setCustomValidity('من فضلك ادخل قيمه المقدم')"
                        oninput="this.setCustomValidity('')" type="number" name="downpayment" id="down-payment" class="myselect"
                                            placeholder="" value="">

                                    </div>
                                </div>
                                <!-- installment length -->
                                <div class="col-lg-3">
                                    <div class="form-group">

                                 <label for="installment-time">
                                  مده الاقساط بالاشهر
                                  <span class="text-danger"> *</span></label>

                                        <input required oninvalid="this.setCustomValidity('من افضلك ادخل مده الاقساط')"
  oninput="this.setCustomValidity('')"  type="number" name="installment_time" id="installment-time"
                                            class="myselect" placeholder="" min="0"
                                            value="">

                                    </div>
                                </div>
                                <!-- installment value -->
                                <!--  <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="installment-value">قيمه القسط</label>
                                        <input required type="number" name="installment_value" id="installment-value"
                                            class="myselect" placeholder="5000 L.E شهريا" min="0">

                                    </div>
                                </div> -->
                                <!-- installment time to recive -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="reciving">الاستلام <span class="text-danger">*</span></label>
                                        <select required oninvalid="this.setCustomValidity('من فضلك اختر الاستلام')"
                                  oninput="this.setCustomValidity('')" name="reciving" id="reciving" class="myselect">
                                            <option  selected disabled  value=""  >اختر</option>
                                            <option value="1">فوري</option>
                                            <option value="0">غير فوري</option>
                                        </select>

                                    </div>
                                </div>
                                <!-- installment time  -->
                                <div class="col-lg-3 recivingTime" id="installment-date-div">
                                   <div class="form-group">
                                    <label for="installment-date">سنه الاستلام<span
                              class="text-danger">*</span></label>
                                       <input required  oninvalid="this.setCustomValidity('من فضلك ادخل  سنه الاستلام')"
                                     oninput="this.setCustomValidity('')"  placeholder="" type="text" name="rec_time"
                                 id="installment-date" min="2022" max="2029" class="myselect" >

                                    </div>
                                </div>

                            </div>
	                	`);
	}else if ($(this).val() == 3 || $(this).val() == 4){


	/*	$('#total-price-div').hide();
		$('#total-price-div input').prop('required',false);

		$('#rent-div').show();
		$('#rent-div input').prop('required',true);

		$('#installment-div').hide();
		$('#installment-div input').prop('required',false);

		$('#boolean-row').hide();
		$('select[name="trade"]').attr('required', false);
		$('select[name="finannce_bank"]').attr('required', false);
		$('select[name="licensed"]').attr('required', false);*/
		$('#showHide').html( `

		                                <div class="row" id="rent-div" style="align-content: start;
                            justify-content: start;">
                                <!-- rent-value -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="rent-value">الايجار الشهري <span
                                                class="text-danger">*</span></label>
                                        <input required min="50" oninvalid="this.setCustomValidity('من فضلك ادخل قيمه الايجار الشهري اعلى من 50')"
                                    oninput="this.setCustomValidity('')"  type="number" name="monthly_rent" id="rent-value" class="myselect"
                                            placeholder="" min="0" >

                                    </div>
                                </div>

                            </div>

		`);
	}else{
	    $('#showHide').html(`
	      <div id="boolean-row" class="row" style="align-content: start;
                            justify-content: start;">

                                <!-- bank-finance -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="bank-finance">تصلح تمويل عقاري <span
                                                class="text-danger">*</span></label>
                                        <select required oninvalid="this.setCustomValidity('من فضلك اختر احدى الاختيارات')"
                         oninput="this.setCustomValidity('')" name="finannce_bank" id="bank-finance" class="myselect">
                                            <option  selected disabled   value="">اختر</option>
                                            <option  value="1" >نعم
                                            </option>
                                            <option value="0" >كلا
                                            </option>
                                        </select>

                                    </div>
                                </div>

                                <!-- trade -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="trade">تصلح للبدل <span class="text-danger">*</span></label>
                                        <select required oninvalid="this.setCustomValidity('من فضلك اختر احدى الاختيارات')"
  oninput="this.setCustomValidity('')" name="trade" id="trade" class="myselect">
                                            <option   selected disabled  value="">اختر</option>
                                            <option value="1" >نعم</option>
                                            <option value="0">كلا</option>
                                        </select>

                                    </div>
                                </div>
                                <!-- signed -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="signed">مسجله شهر عقاري <span class="text-danger">*</span></label>
                                        <select required oninvalid="this.setCustomValidity('من فضلك اختر احد الاختيارات')"
  oninput="this.setCustomValidity('')" name="licensed" id="signed" class="myselect">
                                            <option   selected disabled  value="">اختر</option>
                                            <option value="1" >نعم
                                            </option>
                                            <option value="0" >كلا
                                            </option>
                                        </select>

                                    </div>
                                </div>
                            </div>
	     <div class="col-lg-3" id="total-price-div">
                                <div class="form-group">
                                    <label for="total-price">السعر الاجمالي <span class="text-danger">*</span></label>
                                    <input required  oninvalid="this.setCustomValidity('من فضلك ادخل السعر الاجمالي ')"
  oninput="this.setCustomValidity('')" type="number" name="total_price" id="total-price" class="myselect"
                                        placeholder="" min="50">

                                </div>
                            </div>`);
      /*  $('#installment-div').hide();
		$('#installment-div input').prop('required',false);
		$('#total-price-div').show();
		$('#total-price-div input').prop('required',true);

		$('#rent-div').hide();
		$('#rent-div input').prop('required',false);
		$('#boolean-row').show();
		$('select[name="trade"]').attr('required', true);
		$('select[name="finannce_bank"]').attr('required', true);
		$('select[name="licensed"]').attr('required', true);
*/
	}
});
//$('#rent-div').hide();
$('#license-type-div').hide();
/*
$('#floors-div').hide();
$('#installment-date-div').hide();*/

/*
$('#reciving').on('change',function(){
	if ($(this).val() == 1){


		$('.recivingTime').html('');

	}else {
		$('.recivingTime').html(`
		 <div class="form-group">
                                    <label for="installment-date">سنه الاستلام<span
                              class="text-danger">*</span></label>
                                       <input required  oninvalid="this.setCustomValidity('من فضلك ادخل  سنه الاستلام')"
                                     oninput="this.setCustomValidity('')"  placeholder="" type="text" name="rec_time"
                                 id="installment-date" min="2022" max="2029" class="myselect" >

                                    </div>
		`);


	}
});*/

$('#Property-type').on('change', function () {
	if ($(this).val() == 9) {
		$('#floor-div').hide();
		$('select[name="floor"]').attr('required', false);
		$('#license-type-div').show();
		$('#license-type-div input').prop('required',true);
		$('#finish-type-div').hide();
		$('select[name="finishtype"]').attr('required', false);
		$('#floors-div').hide();
		$('#floors-div input').prop('required',false);

		$('#inner-floor').hide();
		$('#inner-floor input').prop('required',false);



	}
	else if ($(this).val() == 7 || $(this).val() == 20 ||
	 $(this).val() == 21 ||
 $(this).val() == 23 ||   $(this).val() == 16  ){
		$('#license-type-div').hide();
		$('#license-type-div input').prop('required',false);
				////////////////////////////////////
		$('#floor-div').hide();
		$('select[name="floor"]').attr('required', false);
		////////////////////////////////////
		$('#floors-div').show();
		$('#floors-div input').prop('required',true);
				////////////////////////////////////
 	$('#inner-floor').hide();
		$('#inner-floor input').prop('required',false);



	}
	else if (  $(this).val() == 22 ||  $(this).val() == 24 ||
	$(this).val() == 12 || 	$(this).val() == 13 ||  $(this).val() == 18 || $(this).val() == 19 ||
	$(this).val() == 15 ||   $(this).val() == 14 ||
	$(this).val() == 17 )

	{
		$('#license-type-div').hide();
		$('#license-type-div input').prop('required',false);
				////////////////////////////////////
		$('#floor-div').show();
		$('select[name="floor"]').attr('required', true);
		////////////////////////////////////
		$('#floors-div').hide();
		$('#floors-div input').prop('required',false);
				////////////////////////////////////
 	$('#inner-floor').hide();
		$('#inner-floor input').prop('required',false);



	}
	else if ($(this).val() == 2){
		$('#license-type-div').hide();
		$('#license-type-div input').prop('required',false);
		$('#floor-div').hide();
		$('#inner-floor input').prop('required',true);
		$('select[name="floor"]').attr('required', false);

	}




	else{
		$('#inner-floor input').prop('required',true);
		$('#inner-floor').show();

		$('#license-type-div').hide();
		$('#license-type-div input').prop('required',false);

		$('#finish-type-div').show();
		$('select[name="finishtype"]').attr('required', true);
		$('#floor-div').show();

		$('select[name="floor"]').attr('required', true);

		$('#floors-div').hide();
		$('#floors-div input').prop('required',false);




	}
});





  $("#form-3").on("submit", function(){
    $("#pageloader").removeClass('d-none');
    $("#pageloader").addClass('d-flex');
  });//submit




});
