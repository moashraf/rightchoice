//
// $(function () {
// 	"use strict";
//
//
//
//
//
// $('.content-2').hide();
// $('.content-3').hide();
//
// $('#form-1').submit(function (e) {
// 	e.preventDefault();
// 	var x = $("#form-1").serializeArray();
// 	$("#result-form-1").empty();
//
// 	$.each(x, function(i, field){
// 		$("#result-form-1").append(`<input name="${field.name}" value="${field.value}" />`);
// 	  });
//
// 	$('.content-1').hide();
// 	$('.content-2').show();
// 	$('.content-3').hide();
// 	$("html, body").animate({scrollTop: 0}, 1000);
//
// });
//
//
// $('#form-2').submit(function (e) {
//
// 	e.preventDefault();
// 	var y = $("#form-2").serializeArray();
// 	$("#result-form-2").empty();
// 	$.each(y, function(i, field){
// 		$("#result-form-2").append(`<input name="${field.name}" value="${field.value}" />`);
// 	  });
//
// 	$('.content-1').hide();
// 	$('.content-2').hide();
// 	$('.content-3').show();
// 	$("html, body").animate({scrollTop: 0}, 1000);
//
// });
// $('#back-form-1').on('click', function (e) {
// 	e.preventDefault();
// 	$('.content-1').show();
// 	$('.content-2').hide();
// 	$('.content-3').hide();
// 	$("html, body").animate({scrollTop: 0}, 1000);
//
// });
// $('#back-form-2').on('click', function (e) {
// 	e.preventDefault();
// 	$('.content-1').hide();
// 	$('.content-2').show();
// 	$('.content-3').hide();
// 	$("html, body").animate({scrollTop: 0}, 1000);
//
// });
// // Select mzaya
// $('#mzaya').select2({
// 	placeholder: "Advantages",
// 	allowClear: true,
// 	closeOnSelect:false
// }).on('select2:selecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
// .on('select2:select', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')));
//
//
//
// $('#li-cat').on('change', function () {
// 	if ($(this).val() == "2") {
// 		$('#Property-type').html(`
// 		<option  selected disabled  value="">اختر نوع العقار</option>
// 		<option value="14">Shops</option>
// 		<option value="15">Nurseries</option>
// 		<option value="16">Stores</option>
// 		<option value="17">Cafes</option>
// 		<option value="12">Clinics</option>
// 		<option value="18">Moles</option>
// 		<option value="19">Pharmacy</option>
// 		<option value="20">Exhibition</option>
// 		<option value="21">Restaurants</option>
// 		<option value="15">baby daycare</option>
// 		<option value="22">Schools</option>
// 		<option value="23">Factories</option>
//
// 		`);
// 		$('#floor-div').hide();
// 		$('select[name="floor"]').attr('required', true);
//
//
// 	} else if ($(this).val() == "3") {
// 		$('#Property-type').html(`
// 		<option   selected disabled value="">اختر نوع العقار</option>
// 		<option value="1">شقه</option>
// 		<option value="7">عمارات</option>
// 		<option value="12">عيادات</option>
// 		<option value="13">دور كامل</option>0
// 		`);
// 		$('#floor-div').show();
// 		$('#floor-div select').prop('required',true);
//
// 	} else {
// 		$('#Property-type').html(`
// 		<option   selected disabled value="">اختر نوع العقار</option>
// 		<option value="1">شقه</option>
// 		<option value="2">فلل خاصه</option>
// 		<option value="3">روف</option>
// 		<option value="4">استديو</option>
// 		<option value="5">شاليهات</option>
// 		<option value="6">غرف مشاركه</option>
// 		<option value="7">عمارات</option>
// 		<option value="8">شقه دوبلكس</option>
// 		<option value="9">اراضي</option>
// 		<option value="10">توين هاوس</option>
// 		<option value="11">بنتاهاوس</option>
// 		`);
// 		$('#floor-div').show();
// 		$('select[name="floor"]').attr('required', true);
//
// 	}
// });
// $('#installment-div').hide();
//
// $('#offer-type').on('change', function () {
// 	if ($(this).val() == 2) {
//
// 		$('#installment-div').show();
// 		$('#boolean-row').show();
// 		$('select[name="trade"]').attr('required', true);
// 		$('select[name="finannce_bank"]').attr('required', true);
// 		$('select[name="licensed"]').attr('required', true);
// 		$('#total-price-div').show();
// 		$('#total-price-div input').prop('required',true);
// 		$('#rent-div').hide();
// 	}else if ($(this).val() == 3 || $(this).val() == 4){
//
//
// 		$('#total-price-div').hide();
// 		$('#total-price-div input').prop('required',false);
//
// 		$('#rent-div').show();
// 		$('#rent-div input').prop('required',true);
//
// 		$('#installment-div').hide();
// 		$('#installment-div input').prop('required',false);
//
// 		$('#boolean-row').hide();
// 		$('select[name="trade"]').attr('required', false);
// 		$('select[name="finannce_bank"]').attr('required', false);
// 		$('select[name="licensed"]').attr('required', false);
//
// 	}else{
// 		$('#total-price-div').show();
// 		$('#total-price-div input').prop('required',true);
// 		$('#installment-div').hide();
// 		$('#installment-div input').prop('required',false);
// 		$('#rent-div').hide();
// 		$('#rent-div input').prop('required',false);
// 		$('#boolean-row').show();
// 		$('select[name="trade"]').attr('required', true);
// 		$('select[name="finannce_bank"]').attr('required', true);
// 		$('select[name="licensed"]').attr('required', true);
//
// 	}
// });
// $('#rent-div').hide();
// $('#license-type-div').hide();
//
// $('#floors-div').hide();
// $('#installment-date-div').hide();
// $('#reciving').on('change',function(){
// 	if ($(this).val() == 1){
// 		$('#installment-date-div').hide();
//
//
// 	}else {
// 		$('#installment-date-div').show();
//
//
// 	}
// });
//
// $('#Property-type').on('change', function () {
// 	if ($(this).val() == 9) {
// 		$('#floor-div').hide();
// 		$('select[name="floor"]').attr('required', false);
// 		$('#license-type-div').show();
// 		$('#license-type-div input').prop('required',true);
// 		$('#finish-type-div').hide();
// 		$('select[name="finishtype"]').attr('required', false);
// 		$('#floors-div').hide();
// 		$('#floors-div input').prop('required',false);
//
// 		$('#inner-floor').hide();
// 		$('#inner-floor input').prop('required',false);
//
//
//
// 	}
// 	else if ($(this).val() == 7 || $(this).val() == 22 || $(this).val() == 23 ){
// 		$('#license-type-div').hide();
// 		$('#license-type-div input').prop('required',false);
// 		$('#floor-div').hide();
// 		$('select[name="floor"]').attr('required', false);
// 		$('#floors-div').show();
// 		$('#floors-div input').prop('required',true);
//
// 		$('#inner-floor').hide();
// 		$('#inner-floor input').prop('required',false);
//
//
//
// 	}else if ($(this).val() == 2){
// 		$('#license-type-div').hide();
// 		$('#license-type-div input').prop('required',false);
// 		$('#floor-div').hide();
// 		$('#inner-floor input').prop('required',true);
// 		$('select[name="floor"]').attr('required', false);
//
// 	}
// 	else{
// 		$('#inner-floor input').prop('required',true);
// 		$('#inner-floor').show();
//
// 		$('#license-type-div').hide();
// 		$('#license-type-div input').prop('required',false);
//
// 		$('#finish-type-div').show();
// 		$('select[name="finishtype"]').attr('required', true);
// 		$('#floor-div').show();
//
// 		$('select[name="floor"]').attr('required', true);
//
// 		$('#floors-div').hide();
// 		$('#floors-div input').prop('required',false);
//
//
//
//
// 	}
// });
//
//
//
//
//
//
//
//
//
//
//
// });
//
