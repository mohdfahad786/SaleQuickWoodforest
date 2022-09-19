(function ($) {
 "use strict";
$(document).ready(function(){
	  
		/*
		Mean Menu Responsive
		============================*/		
        jQuery('nav#main-menu').meanmenu();						
		/*
		Testimonial Crousel
		============================*/ 	
		  $(".all-testimonial").owlCarousel({
			autoPlay: false, 
			slideSpeed:2000,
			pagination:false,
			nav:true, 
			dots:true, 
			items :3,
			navText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
			itemsDesktop : [1199,2],
			itemsDesktopSmall : [980,2],
			itemsTablet: [768,1],
			itemsTablet: [767,1],
			itemsMobile : [479,1],
		  }); 					
		/*
		Slider Crousel
		============================*/ 
		$(".all-slide").owlCarousel({
            items: 1,
            nav: true,
            dots: true,
            autoplay: true,
            loop: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            mouseDrag: false,
            touchDrag: false,
        });
        
        $(".all-slide").on("translate.owl.carousel", function(){
            $(".slider-text *").removeClass("animated fadeInUp").css("opacity", "0");
            $(".slider-text *").removeClass("animated fadeInDown").css("opacity", "0");
        });
        
        $(".all-slide").on("translated.owl.carousel", function(){
            $(".slider-text *").addClass("animated fadeInUp").css("opacity", "1");
            $(".slider-text *").addClass("animated fadeInDown").css("opacity", "1");
        });
		/*
		scrollUp
		============================*/	
		$.scrollUp({
			scrollText: '<i class="fa fa-angle-up"></i>',
			easingType: 'linear',
			scrollSpeed: 900,
			animation: 'fade'
		});	
		/*
		Counter Js
		============================*/ 
        $('.counter').counterUp({
            delay: 10,
            time: 1000			
        }); 				
		/*
		Magnific Popup
		============================*/ 		
        $('.gallery-photo').magnificPopup({
            type: 'image',
            gallery: {
              enabled: true
            },
        });	 
		/*
		Preeloader
		============================*/
		$(window).load(function() {
			$('#preloader').fadeOut();
			$('#preloader-status').delay(200).fadeOut('slow');
			$('body').delay(200).css({'overflow-x':'hidden'});
		});
		
	});	
})(jQuery);

