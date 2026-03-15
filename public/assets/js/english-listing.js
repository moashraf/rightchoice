
$(function () {
	"use strict";





$('.content-2').hide();
$('.content-3').hide();

$('#form-1').submit(function (e) {
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
	placeholder: "Advantages",
	allowClear: true,
	closeOnSelect:false
}).on('select2:selecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
.on('select2:select', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')));



$('#li-cat').on('change', function () {
	var catId = $(this).val();
	var $propertyType = $('#Property-type');

	$propertyType.html('<option selected disabled value="">Loading...</option>');

	$.ajax({
		url: '/api/fetch-property-types',
		type: 'GET',
		data: {
			cat_id: catId
		},
		success: function (data) {
			var options = '<option selected disabled value="">Select Property Type</option>';
			$.each(data, function (i, item) {
				options += '<option value="' + item.id + '">' + (item.property_type_en || item.property_type) + '</option>';
			});
			$propertyType.html(options);

			if (catId == "2") {
				$('#floor-div').hide();
				$('select[name="floor"]').attr('required', false);
			} else {
				$('#floor-div').show();
				$('select[name="floor"]').attr('required', true);
			}
		},
		error: function () {
			$propertyType.html('<option selected disabled value="">Select Property Type</option>');
		}
	});
});
$('#installment-div').hide();

$('#offer-type').on('change', function () {
	if ($(this).val() == 2) {

		$('#installment-div').show();
		$('#boolean-row').show();
		$('select[name="trade"]').attr('required', true);
		$('select[name="finannce_bank"]').attr('required', true);
		$('select[name="licensed"]').attr('required', true);
		$('#total-price-div').show();
		$('#total-price-div input').prop('required',true);
		$('#rent-div').hide();
	}else if ($(this).val() == 3 || $(this).val() == 4){


		$('#total-price-div').hide();
		$('#total-price-div input').prop('required',false);

		$('#rent-div').show();
		$('#rent-div input').prop('required',true);

		$('#installment-div').hide();
		$('#installment-div input').prop('required',false);

		$('#boolean-row').hide();
		$('select[name="trade"]').attr('required', false);
		$('select[name="finannce_bank"]').attr('required', false);
		$('select[name="licensed"]').attr('required', false);

	}else{
		$('#total-price-div').show();
		$('#total-price-div input').prop('required',true);
		$('#installment-div').hide();
		$('#installment-div input').prop('required',false);
		$('#rent-div').hide();
		$('#rent-div input').prop('required',false);
		$('#boolean-row').show();
		$('select[name="trade"]').attr('required', true);
		$('select[name="finannce_bank"]').attr('required', true);
		$('select[name="licensed"]').attr('required', true);

	}
});
$('#rent-div').hide();
$('#license-type-div').hide();

$('#floors-div').hide();
$('#installment-date-div').hide();
$('#reciving').on('change',function(){
	if ($(this).val() == 1){
		$('#installment-date-div').hide();


	}else {
		$('#installment-date-div').show();


	}
});

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
	else if ($(this).val() == 7 || $(this).val() == 22 || $(this).val() == 23 ){
		$('#license-type-div').hide();
		$('#license-type-div input').prop('required',false);
		$('#floor-div').hide();
		$('select[name="floor"]').attr('required', false);
		$('#floors-div').show();
		$('#floors-div input').prop('required',true);

		$('#inner-floor').hide();
		$('#inner-floor input').prop('required',false);



	}else if ($(this).val() == 2){
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











});

