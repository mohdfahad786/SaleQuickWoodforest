$(window).on("load", function() {
    "use strict";


    /* ============  Features Carousel ================*/
    $('.slash-features-carousel').owlCarousel({
        autoplay:true,
        autoplayTimeout:2500,
        smartSpeed:2000,
        loop:false,
        dots:true,
        nav:false,
        margin:30,
        mouseDrag:true,
        items:2,
        autoHeight:true,
        responsive :{
            1200 :{items:2},            
            980 :{items:2},         
            767 :{items:2},            
            480 :{items:2},                
            0 :{items:1}      
        }  
    });

    /* ============  Screenshots ================*/
    $('.slash-screenshots').owlCarousel({
        autoplay:true,
        autoplayTimeout:2500,
        smartSpeed:2000,
        loop:false,
        dots:true,
        nav:false,
        margin:0,
        mouseDrag:true,
        items:4,
        autoHeight:true,
        responsive :{
            1200:{items:4},            
            980:{items:4},         
            767:{items:3},            
            480:{items:2},                
            0:{items:1}      
        }  
    });

    /* ============  Testimonials ================*/
    $('.slash-testimonials').owlCarousel({
        autoplay:true,
        autoplayTimeout:2500,
        smartSpeed:2000,
        loop:true,
        dots:true,
        nav:false,
        margin:0,
        mouseDrag:true,
        singleItem:true,
        items:1,
        autoHeight:true,
        animateIn:"fadeIn",
        animateOut:"fadeOut",
    });

    /* ============ Mockup Carousel ================*/
    $('.mockup-carousel, .saas-mockup-carousel').owlCarousel({
        autoplay:true,
        autoplayTimeout:2500,
        smartSpeed:2000,
        loop:true,
        dots:true,
        nav:false,
        margin:0,
        mouseDrag:true,
        singleItem:true,
        items:1,
        autoHeight:true,
        animateIn:"fadeIn",
        animateOut:"fadeOut"
    });

    /*=================== Sticky Header ===================*/
    $(window).on("scroll",function(){
        var scroll = $(window).scrollTop();
        var hstick = $("header.stick");
        if (scroll > 20){
            hstick.addClass("sticky");
        } else{
            hstick.removeClass("sticky");
        }

    });


    /*=================== Accordion ===================*/
    $(".toggle").each(function(){
        $(this).find('.content').hide();
        $(this).find('h2:first').addClass('active').next().slideDown(500).parent().addClass("activate");
        $('h2', this).click(function() {
            if ($(this).next().is(':hidden')) {
                $(this).parent().parent().find("h2").removeClass('active').next().slideUp(500).removeClass('animated fadeInUp').parent().removeClass("activate");
                $(this).toggleClass('active').next().slideDown(500).addClass('animated fadeInUp').parent().toggleClass("activate");
            }
        });
    });


    $(".menu-btn").on("click",function(){
        $("nav").addClass('active');
        return false;
    });
    $("html").on("click",function(){
        $("nav").removeClass('active');
    });

});