



  window.addEventListener('load',function(){

    document.querySelector('body').classList.add("loaded")  

  });

  

$(function () {

	"use strict";

$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = jQuery('.passwordInput');
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

// 	$('#motwar').hide();
	$('#user-type').on('change', function () {
		if ($(this).val() == "3") {
			$('#motwar').show();
			$('#motwar input').prop('required', true);
			$('#age-div').hide();
			$('#age-div select').prop('required', false);
			
	$('#termsCheckLabel').html(',و اقر باننا شركه تطوير عقاري ملاك مباشرين للوحدات ولسنا شركه تسويق عقاري او وساطه عقاريه  ولانتقاضى اي عمولات او رسوم')
				
			
		}else {
			$('#motwar').hide();
			$('#motwar input').prop('required', false);
			$('#age-div').show();
			$('#age-div select').prop('required', true);
			$('#termsCheckLabel').html('')
			
			
		}
	});
	
	$(window).scroll(function() {    

		var scroll = $(window).scrollTop();

	

		if (scroll >= 50) {

			$("#clearfix").addClass("clear");

		} else {

			$("#clearfix").removeClass("clear");

		}

	});



	/*---- Bottom To Top Scroll Script ---*/

	$(window).on('scroll', function () {

		var height = $(window).scrollTop();

		if (height > 100) {

			$('#back2Top').fadeIn();

			

		} else {

			$('#back2Top').fadeOut();

		}

	});



	$("#back2Top").on('click', function (event) {

		event.preventDefault();

		$("html, body").animate({ scrollTop: 0 }, "slow");

		return false;

	});



	// Navigation

	! function (n, e, i, a) {

		n.navigation = function (t, s) {

			var o = {

				responsive: !0,

				mobileBreakpoint: 992,

				showDuration: 1000,

				hideDuration: 1000,

				showDelayDuration: 0,

				hideDelayDuration: 0,

				submenuTrigger: "click",

				effect: "fade",

				submenuIndicator: !0,

				hideSubWhenGoOut: !0,

				visibleSubmenusOnMobile: !1,

				fixed: !1,

				overlay: !0,

				overlayColor: "rgba(0, 0, 0, 0.5)",

				hidden: !1,

				offCanvasSide: "left",

				onInit: function () { },

				onShowOffCanvas: function () {
				    
				 //   setTimeout(function () { this.close();}, 1000);
				},

				onHideOffCanvas: function () { }

			},

				u = this,

				r = Number.MAX_VALUE,

				d = 1,

				f = "click.nav touchstart.nav",

				l = "mouseenter.nav",

				c = "mouseleave.nav";

			u.settings = {};

			var t = (n(t), t);

			n(t).find(".nav-menus-wrapper").prepend("<span class='nav-menus-wrapper-close-button'>✕</span>"), n(t).find(".nav-search").length > 0 && n(t).find(".nav-search").find("form").prepend("<span class='nav-search-close-button'>✕</span>"), u.init = function () {

				u.settings = n.extend({}, o, s), "right" == u.settings.offCanvasSide && n(t).find(".nav-menus-wrapper").addClass("nav-menus-wrapper-right"), u.settings.hidden && (n(t).addClass("navigation-hidden"), u.settings.mobileBreakpoint = 99999), v(), u.settings.fixed && n(t).addClass("navigation-fixed"), n(t).find(".nav-toggle").on("click touchstart", function (n) {

					n.stopPropagation(), n.preventDefault(), u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")

				}), n(t).find(".nav-menus-wrapper-close-button").on("click touchstart", function () {

					u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")

				}), n(t).find(".nav-search-button").on("click touchstart", function (n) {

					n.stopPropagation(), n.preventDefault(), u.toggleSearch()

				}), n(t).find(".nav-search-close-button").on("click touchstart", function () {

					u.toggleSearch()

				}), n(t).find(".megamenu-tabs").length > 0 && y(), n(e).resize(function () {

					m(), C()

				}), m(), s !== a && u.callback("onInit")

			};

			var v = function () {

				n(t).find("li").each(function () {

					n(this).children(".nav-dropdown,.megamenu-panel").length > 0 && (n(this).children(".nav-dropdown,.megamenu-panel").addClass("nav-submenu"), u.settings.submenuIndicator && n(this).children("a").append("<span class='submenu-indicator'><span class='submenu-indicator-chevron'></span></span>"))

				})

			};

			u.showSubmenu = function (e, i) {

				g() > u.settings.mobileBreakpoint && n(t).find(".nav-search").find("form").slideUp(), "fade" == i ? n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).fadeIn(u.settings.showDuration) : n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).slideDown(u.settings.showDuration), n(e).addClass("nav-submenu-open")

			}, u.hideSubmenu = function (e, i) {

				"fade" == i ? n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).fadeOut(u.settings.hideDuration) : n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).slideUp(u.settings.hideDuration), n(e).removeClass("nav-submenu-open").find(".nav-submenu-open").removeClass("nav-submenu-open")

			};

			var h = function () {

				n("body").addClass("no-scroll"), u.settings.overlay && (n(t).append("<div class='nav-overlay-panel'></div>"), n(t).find(".nav-overlay-panel").css("background-color", u.settings.overlayColor).fadeIn(300).on("click touchstart", function (n) {

					u.hideOffcanvas()

				}))

			},

				p = function () {

					n("body").removeClass("no-scroll"), u.settings.overlay && n(t).find(".nav-overlay-panel").fadeOut(400, function () {

						n(this).remove()

					})

				};

			u.showOffcanvas = function () {

				h(), "left" == u.settings.offCanvasSide ? n(t).find(".nav-menus-wrapper").css("transition-property", "left").addClass("nav-menus-wrapper-open") : n(t).find(".nav-menus-wrapper").css("transition-property", "right").addClass("nav-menus-wrapper-open")

			}, u.hideOffcanvas = function () {

				n(t).find(".nav-menus-wrapper").removeClass("nav-menus-wrapper-open").on("webkitTransitionEnd moztransitionend transitionend oTransitionEnd", function () {

					n(t).find(".nav-menus-wrapper").css("transition-property", "none").off()

				}), p()

			}, u.toggleOffcanvas = function () {

				g() <= u.settings.mobileBreakpoint && (n(t).find(".nav-menus-wrapper").hasClass("nav-menus-wrapper-open") ? (u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")) : (u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")))

			}, u.toggleSearch = function () {

				"none" == n(t).find(".nav-search").find("form").css("display") ? (n(t).find(".nav-search").find("form").slideDown(), n(t).find(".nav-submenu").fadeOut(200)) : n(t).find(".nav-search").find("form").slideUp()

			};

			var m = function () {

				u.settings.responsive ? (g() <= u.settings.mobileBreakpoint && r > u.settings.mobileBreakpoint && (n(t).addClass("navigation-portrait").removeClass("navigation-landscape"), D()), g() > u.settings.mobileBreakpoint && d <= u.settings.mobileBreakpoint && (n(t).addClass("navigation-landscape").removeClass("navigation-portrait"), k(), p(), u.hideOffcanvas()), r = g(), d = g()) : k()

			},

				b = function () {

					n("body").on("click.body touchstart.body", function (e) {

						0 === n(e.target).closest(".navigation").length && (n(t).find(".nav-submenu").fadeOut(), n(t).find(".nav-submenu-open").removeClass("nav-submenu-open"), n(t).find(".nav-search").find("form").slideUp())

					})

				},

				g = function () {

					return e.innerWidth || i.documentElement.clientWidth || i.body.clientWidth

				},

				w = function () {

					n(t).find(".nav-menu").find("li, a").off(f).off(l).off(c)

				},

				C = function () {

					if (g() > u.settings.mobileBreakpoint) {

						var e = n(t).outerWidth(!0);

						n(t).find(".nav-menu").children("li").children(".nav-submenu").each(function () {

							n(this).parent().position().left + n(this).outerWidth() > e ? n(this).css("right", 0) : n(this).css("right", "auto")

						})

					}

				},

				y = function () {

					function e(e) {

						var i = n(e).children(".megamenu-tabs-nav").children("li"),

							a = n(e).children(".megamenu-tabs-pane");

						n(i).on("click.tabs touchstart.tabs", function (e) {

							e.stopPropagation(), e.preventDefault(), n(i).removeClass("active"), n(this).addClass("active"), n(a).hide(0).removeClass("active"), n(a[n(this).index()]).show(0).addClass("active")

						})

					}

					if (n(t).find(".megamenu-tabs").length > 0)

						for (var i = n(t).find(".megamenu-tabs"), a = 0; a < i.length; a++) e(i[a])

				},

				k = function () {

					w(), n(t).find(".nav-submenu").hide(0), navigator.userAgent.match(/Mobi/i) || navigator.maxTouchPoints > 0 || "click" == u.settings.submenuTrigger ? n(t).find(".nav-menu, .nav-dropdown").children("li").children("a").on(f, function (i) {

						if (u.hideSubmenu(n(this).parent("li").siblings("li"), u.settings.effect), n(this).closest(".nav-menu").siblings(".nav-menu").find(".nav-submenu").fadeOut(u.settings.hideDuration), n(this).siblings(".nav-submenu").length > 0) {

							if (i.stopPropagation(), i.preventDefault(), "none" == n(this).siblings(".nav-submenu").css("display")) return u.showSubmenu(n(this).parent("li"), u.settings.effect), C(), !1;

							if (u.hideSubmenu(n(this).parent("li"), u.settings.effect), "_blank" == n(this).attr("target") || "blank" == n(this).attr("target")) e.open(n(this).attr("href"));

							else {

								if ("#" == n(this).attr("href") || "" == n(this).attr("href")) return !1;

								e.location.href = n(this).attr("href")

							}

						}

					}) : n(t).find(".nav-menu").find("li").on(l, function () {

						u.showSubmenu(this, u.settings.effect), C()

					}).on(c, function () {

						u.hideSubmenu(this, u.settings.effect)

					}), u.settings.hideSubWhenGoOut && b()

				},

				D = function () {

					w(), n(t).find(".nav-submenu").hide(0), u.settings.visibleSubmenusOnMobile ? n(t).find(".nav-submenu").show(0) : (n(t).find(".nav-submenu").hide(0), n(t).find(".submenu-indicator").removeClass("submenu-indicator-up"), u.settings.submenuIndicator ? n(t).find(".submenu-indicator").on(f, function (e) {

						return e.stopPropagation(), e.preventDefault(), u.hideSubmenu(n(this).parent("a").parent("li").siblings("li"), "slide"), u.hideSubmenu(n(this).closest(".nav-menu").siblings(".nav-menu").children("li"), "slide"), "none" == n(this).parent("a").siblings(".nav-submenu").css("display") ? (n(this).addClass("submenu-indicator-up"), n(this).parent("a").parent("li").siblings("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), n(this).closest(".nav-menu").siblings(".nav-menu").find(".submenu-indicator").removeClass("submenu-indicator-up"), u.showSubmenu(n(this).parent("a").parent("li"), "slide"), !1) : (n(this).parent("a").parent("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), void u.hideSubmenu(n(this).parent("a").parent("li"), "slide"))

					}) : k())

				};

			u.callback = function (n) {

				s[n] !== a && s[n].call(t)

			}, u.init()

		}, n.fn.navigation = function (e) {

			return this.each(function () {

				if (a === n(this).data("navigation")) {

					var i = new n.navigation(this, e);

					n(this).data("navigation", i)

				}

			})

		}

	}

		(jQuery, window, document), $(document).ready(function () {

			$("#navigation").navigation()

		});



	$(window).scroll(function () {

		var scroll = $(window).scrollTop();



		if (scroll >= 50) {

			$(".header").addClass("header-fixed");

		} else {

			$(".header").removeClass("header-fixed");

		}

	});





	// Compare Slide

	$('.csm-trigger').on('click', function () {

		$('.compare-slide-menu').toggleClass('active');

	});

	$('.compare-button').on('click', function () {

		$('.compare-slide-menu').addClass('active');

	});



	



	// Property Slide

	$('.property-slide').slick({

		slidesToShow: 4,

		arrows: true,

		dots: true,

		autoplay: false,

		responsive: [

			{

				breakpoint: 1024,

				settings: {

					arrows: false,

					slidesToShow: 2

				}

			},

			{

				breakpoint: 600,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			}

		]

	});






	$('.vip-slide').slick({

		slidesToShow: 2,

		arrows: false,

		dots: true,

		autoplay: true,

		responsive: [

			{

				breakpoint: 1024,

				settings: {

					arrows: false,

					slidesToShow: 2

				}

			},

			{

				breakpoint: 600,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			}

		]

	});





	// hero Slide-1

	$('.hero-slide-1').slick({

		slidesToShow: 1,

		arrows: false,

		dots: true,

		autoplay: true,
		
		autoplaySpeed: 10000,

		
		 speed: 3000,


		responsive: [

			{

				breakpoint: 1024,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			},

			{

				breakpoint: 980, // tablet breakpoint

				settings: {

					slidesToShow: 1,

					slidesToScroll: 3

				}

			},

			{

				breakpoint: 980, // tablet breakpoint

				settings: {

					slidesToShow: 1,

					slidesToScroll: 3

				}

			},



			{

				breakpoint: 600,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			},

			{

				breakpoint: 480, // mobile breakpoint

				settings: {

					slidesToShow: 1,

					slidesToScroll: 2

				}

			}

		]

	});

	// advertisment Slider

	$('.adv-slider').slick({

		slidesToShow: 1,

		arrows: false,

		dots: true,

		autoplay: true,

		responsive: [

			{

				breakpoint: 1024,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			},

			{

				breakpoint: 600,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			}

		]

	});





	//lazy slide

	$('.lazy').slick({

		dots: false,

		arrows: false,
		autoplay: true,

		infinite: true,

		speed: 3000,

		slidesToShow: 3,

		adaptiveHeight: true,

		responsive: [

			{

				breakpoint: 1024,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			},

			{

				breakpoint: 600,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			}

		]

	});

	// location Slide

	$('.location-slide').slick({

		slidesToShow: 4,

		dots: true,

		arrows: false,

		autoplay: true,

		responsive: [

			{

				breakpoint: 1024,

				settings: {

					arrows: false,

					slidesToShow: 3

				}

			},

			{

				breakpoint: 600,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			}

		]

	});

	// location Slide

	$('.small-img-slide').slick({

		slidesToShow: 1,

		dots: false,

		arrows: true,

		autoplay: true,

		responsive: [

			{

				breakpoint: 1024,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			},

			{

				breakpoint: 600,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			}

		]

	});

	// Property Slide

	$('.team-slide').slick({

		slidesToShow: 4,

		arrows: false,

		autoplay: true,

		dots: true,

		responsive: [

			{

				breakpoint: 1023,

				settings: {

					arrows: false,

					dots: true,

					slidesToShow: 3

				}

			},

			{

				breakpoint: 768,

				settings: {

					arrows: false,

					slidesToShow: 2

				}

			},

			{

				breakpoint: 480,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			}

		]

	});



	// Featured Slick Slider

	$('.featured_slick_gallery-slide').slick({

		centerMode: true,
		autoplay:false,

		infinite: true,

		centerPadding: '40px',

		slidesToShow: 2,

		responsive: [

			{

				breakpoint: 768,

				settings: {

					arrows: true,

					centerMode: true,

					centerPadding: '20px',

					slidesToShow: 3

				}

			},

			{

				breakpoint: 480,

				settings: {

					arrows: false,

					centerMode: true,

					centerPadding: '20px',

					slidesToShow: 1

				}

			}

		]

	});



	// Range Slider Script

	$(".js-range-slider").ionRangeSlider({

		type: "double",

		min: 0,

		max: 1000,

		from: 200,

		to: 500,

		grid: true

	});

	// Select Min price

	$('#minprice').select2({

		placeholder: "No Min",

		allowClear: true

	});



	





	// Select Max Price

	$('#maxprice').select2({

		placeholder: "No Max",

		allowClear: true

	});





	// Home Slider

	$('.home-slider').slick({

		centerMode: false,

		slidesToShow: 1,

		responsive: [

			{

				breakpoint: 768,

				settings: {

					arrows: true,

					slidesToShow: 1

				}

			},

			{

				breakpoint: 480,

				settings: {

					arrows: false,

					slidesToShow: 1

				}

			}

		]

	});



	$('.click').slick({

		slidesToShow: 1,

		slidesToScroll: 1,

		autoplay: false,
		arrows:false,

		autoplayspeed: 3000,



	});



	// Advance Single Slider

	$(function () {

		// Card's slider

		var $carousel = $('.slider-for');



		$carousel

			.slick({

				slidesToShow: 1,

				slidesToScroll: 1,

				arrows: false,

				fade: true,
				autoplay:false,

				adaptiveHeight: true,

				asNavFor: '.slider-nav'

			})

			.magnificPopup({

				type: 'image',

				delegate: 'a:not(.slick-cloned)',

				closeOnContentClick: false,

				tLoading: 'Загрузка...',

				mainClass: 'mfp-zoom-in mfp-img-mobile',

				image: {

					verticalFit: true,

					tError: '<a href="%url%">Фото #%curr%</a> не загрузилось.'

				},

				gallery: {

					enabled: true,

					navigateByImgClick: true,

					tCounter: '<span class="mfp-counter">%curr% из %total%</span>', // markup of counte

					preload: [0, 1] // Will preload 0 - before current, and 1 after the current image

				},

				zoom: {

					enabled: true,

					duration: 300

				},

				removalDelay: 300, //delay removal by X to allow out-animation

				callbacks: {

					open: function () {

						//overwrite default prev + next function. Add timeout for css3 crossfade animation

						$.magnificPopup.instance.next = function () {

							var self = this;

							self.wrap.removeClass('mfp-image-loaded');

							setTimeout(function () { $.magnificPopup.proto.next.call(self); }, 120);

						};

						$.magnificPopup.instance.prev = function () {

							var self = this;

							self.wrap.removeClass('mfp-image-loaded');

							setTimeout(function () { $.magnificPopup.proto.prev.call(self); }, 120);

						};

						var current = $carousel.slick('slickCurrentSlide');

						$carousel.magnificPopup('goTo', current);

					},

					imageLoadComplete: function () {

						var self = this;

						setTimeout(function () { self.wrap.addClass('mfp-image-loaded'); }, 16);

					},

					beforeClose: function () {

						$carousel.slick('slickGoTo', parseInt(this.index));

					}

				}

			});

		$('.slider-nav').slick({

			slidesToShow: 6,

			slidesToScroll: 1,

			asNavFor: '.slider-for',

			dots: false,

			centerMode: false,

			focusOnSelect: true

		});





	});



	// Featured Slick Slider

	$('.featured-slick-slide').slick({

		centerMode: true,

		centerPadding: '80px',

		slidesToShow: 2,

		responsive: [

			{

				breakpoint: 768,

				settings: {

					arrows: true,

					centerMode: true,

					centerPadding: '60px',

					slidesToShow: 2

				}

			},

			{

				breakpoint: 480,

				settings: {

					arrows: false,

					centerMode: true,

					centerPadding: '40px',

					slidesToShow: 1

				}

			}

		]

	});



	// MagnificPopup

	$('body').magnificPopup({

		type: 'image',

		delegate: 'a.mfp-gallery',

		fixedContentPos: true,

		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: false,

		preloader: true,

		removalDelay: 0,

		mainClass: 'mfp-fade',

		gallery: {

			enabled: true

		}

	});



	// fullwidth home slider

	function inlineCSS() {

		$(".home-slider .item").each(function () {

			var attrImageBG = $(this).attr('data-background-image');

			var attrColorBG = $(this).attr('data-background-color');

			if (attrImageBG !== undefined) {

				$(this).css('background-image', 'url(' + attrImageBG + ')');

			}

			if (attrColorBG !== undefined) {

				$(this).css('background', '' + attrColorBG + '');

			}

		});

	}

	inlineCSS();



	// Search Radio

	function searchTypeButtons() {

		$('.property-search-type label.active input[type="radio"]').prop('checked', true);

		var buttonWidth = $('.property-search-type label.active').width();

		var arrowDist = $('.property-search-type label.active').position();

		$('.property-search-type-arrow').css('left', arrowDist + (buttonWidth / 2));

		$('.property-search-type label').on('change', function () {

			$('.property-search-type input[type="radio"]').parent('label').removeClass('active');

			$('.property-search-type input[type="radio"]:checked').parent('label').addClass('active');

			var buttonWidth = $('.property-search-type label.active').width();

			var arrowDist = $('.property-search-type label.active').position().left;

			$('.property-search-type-arrow').css({

				'left': arrowDist + (buttonWidth / 1.7),

				'transition': 'left 0.4s cubic-bezier(.95,-.41,.19,1.44)'

			});

		});

	}

	if ($(".hero-banner").length) {

		searchTypeButtons();

		$(window).on('load resize', function () {

			searchTypeButtons();

		});

	};



	$('#trigger').click(function() {

		$('#overlay').fadeIn(300);

	 });

  

	 $('#close').click(function() {

		$('#overlay').fadeOut(300);

	 });

	 

	 $('#trigger-2').click(function() {

		$('#overlay-2').fadeIn(300);

	 });


	 
	 $('#trigger-3').click(function() {

		$('#overlay-3').fadeIn(300);

	 });

  

	 $('#close-2').click(function() {

		$('#overlay-2').fadeOut(300);

	 });

	 $(document).bind('keydown', function(e) { 

        if (e.which == 27) {

			$('#overlay').fadeOut(300);



			$('#overlay-2').fadeOut(300);



        }

    }); 


	
	$('#close-3').click(function() {

		$('#overlay-3').fadeOut(300);

	 });

	 $(document).bind('keydown', function(e) { 

        if (e.which == 27) {

			$('#overlay').fadeOut(300);



			$('#overlay-3').fadeOut(300);



        }

    }); 

	var $temp = $("<input>");

var $url = $(location).attr('href');



$('.clipboard').on('click', function() {

  $("body").append($temp);

  $temp.val($url).select();

  document.execCommand("copy");

  $temp.remove();

  $(".clipboard").html("URL copied!");

});

















var btnUpload = $("#upload_file"),

		btnOuter = $(".button_outer");

	btnUpload.on("change", function(e){

		var ext = btnUpload.val().split('.').pop().toLowerCase();

		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {

			$(".error_msg").text("Not an Image...");

		} else {

			$(".error_msg").text("");

			btnOuter.addClass("file_uploading");

			setTimeout(function(){

				btnOuter.addClass("file_uploaded");

			},3000);

			var uploadedFile = URL.createObjectURL(e.target.files[0]);

			setTimeout(function(){

				$("#uploaded_view").append('<img src="'+uploadedFile+'" />').addClass("show");

			},3500);

		}

	});

	$(".file_remove").on("click", function(e){

		$("#uploaded_view").removeClass("show");

		$("#uploaded_view").find("img").remove();

		btnOuter.removeClass("file_uploading");

		btnOuter.removeClass("file_uploaded");

	});











});





document.getElementById("url").innerHTML =

 window.location.href;











// Get the modal

var modal = document.getElementById("myModal");



// Get the button that opens the modal

var btn = document.getElementById("myBtn");



// Get the <span> element that closes the modal

var span = document.getElementsByClassName("close")[0];


/*
// When the user clicks on the button, open the modal

//btn.onclick = function() {

  //modal.style.display = "block";

//}



// When the user clicks on <span> (x), close the modal

//span.onclick = function() {

//  modal.style.display = "none";

//}

*/

// When the user clicks anywhere outside of the modal, close it
/*
window.onclick = function(event) {

  if (event.target == modal) {

    modal.style.display = "none";

  }

}






*/






var imgUpload = document.getElementById('upload_imgs')

  , imgPreview = document.getElementById('img_preview')

  , imgUploadForm = document.getElementById('img-upload-form')

  , totalFiles

  , previewTitle

  , previewTitleText

  , img;





function previewImgs(event) {

  totalFiles = imgUpload.files.length;

  

  if(!!totalFiles) {

    imgPreview.classList.remove('quote-imgs-thumbs--hidden');

    previewTitle = document.createElement('p');

    previewTitle.style.fontWeight = 'bold';

    previewTitleText = document.createTextNode(totalFiles + ' Total Images Selected');

    previewTitle.appendChild(previewTitleText);

    imgPreview.appendChild(previewTitle);

  }

  

  for(var i = 0; i < totalFiles; i++) {

    img = document.createElement('img');

    img.src = URL.createObjectURL(event.target.files[i]);

    img.classList.add('img-preview-thumb');

    imgPreview.appendChild(img);

  }

}



window.onload = function() {
    var $recaptcha = document.querySelector('#recaptcha-token');

    if($recaptcha) {
        $recaptcha.setAttribute("required", "required");
    }
};