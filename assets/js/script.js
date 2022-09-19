
$(window).scroll(function() {
    var height = $(window).scrollTop();

    if(height  > 60) {
      $('.header-wraper').addClass('scrolled');
    }
    else{
      $('.header-wraper').removeClass('scrolled');
    }
});
$(window).scroll(function() {
    if ($(this).scrollTop() >= 60) {        // If page is scrolled more than 60px
        $('.header-wraper').addClass('scrolled');
        $('#return-to-top').addClass('active');
        $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
        $('.header-wraper').removeClass('scrolled');
        $('#return-to-top').removeClass('active');
        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
});

$('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 800);
});

$(document)
  .ready(function(){
    $('.vertical_scroll').mCustomScrollbar({
      axis: "y",
      theme: "minimal",
      scrollInertia: 400
    });
    if ($(window).scrollTop() >= 60) {        // If page is scrolled more than 60px
        $('.header-wraper').addClass('scrolled');
        $('#return-to-top').addClass('active');
        $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
        $('.header-wraper').removeClass('scrolled');
        $('#return-to-top').removeClass('active');
        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
    // Add scrollspy to <body>
    $('body').scrollspy({target: ".navbar", offset: 50});   

    // Add smooth scrolling on all links inside the navbar
    $("#myNavbar a").on('click', function(event) {
      // Make sure this.hash has a value before overriding default behavior
      if (this.hash !== "") {
        // Prevent default anchor click behavior
        if($('#howItWork').length)
        {
          event.preventDefault();
        }

        // Store hash
        var hash = this.hash;
        console.log(hash)

        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
          scrollTop: $(hash).offset().top
        }, 800, function(){
     
          // Add hash (#) to URL when done scrolling (default click behavior)
          window.location.hash = hash;
        });
      }  // End if
    });
    new WOW().init();//initialization of wow-animation
    setTimeout(function(){
      $('.banar h2.textAnimate').addClass('onePt1');
    },400)
  })
    .on('click','.mcl_tabs_menu a',function(e){
        e.preventDefault();
        $(this).closest('.mcl_tabs_menu').find('a').removeClass('active');
        $(this).addClass('active');
        var newId=$(this).attr('data-id');
        $('.apiMcl.productP').find('.api_code_wraper').removeClass('active');
        $('#apiMclCarousel .api_code_wraper').removeClass('active');
        $('#'+newId).addClass('active');
    })
  .on('click','.giveItTryPopup .dropdown-menu',function(e){
    // $(this).closest('.carousel-inner').addClass('go-up');
    e.stopPropagation();
  })
  .on('click','.giveItTryPopup .dropdown-toggle',function(e){
    console.log('clicked')
    $(this).closest('.carousel-inner').addClass('go-up');
  })
  .on('click',function(e){
    if(!$('.giveItTryPopup.open .dropdown-menu').length)
    $('.carousel-inner').removeClass('go-up');
  })
// $(window).on('load',function() {
//     $('.banar h.textAnimate').addClass('onePt1');
//     setTimeout(function(){
//       $('.banar h2.textAnimate').addClass('onePt1');
//     },400)
// });
//------------------------------------------------------------------------

function elemInView($elem){
    var top_of_element = $elem.offset().top;
    var bottom_of_element = $elem.offset().top + $elem.outerHeight();
    var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
    var top_of_screen = $(window).scrollTop();

    if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element)){
        // the element is visible, do something
        return true;
    } else {
        // the element is not visible, do something else
        return false;
    }
}


function checkSliders(){
     /*1*/
    var $ptOfSaleCarousel=$('#ptOfSaleCarousel'),$sendDetailCarousel=$('#sendDetailCarousel'),$apiMclCarousel=$('#apiMclCarousel');

    if($ptOfSaleCarousel.length)//exist
    {
        if ($ptOfSaleCarousel.closest('section').hasClass('view'))
        {//visible
            $sendDetailCarousel.carousel("pause");
            $apiMclCarousel.carousel("pause");
            $ptOfSaleCarousel.carousel("cycle");
        } 
        else 
        { //not visible  
            $ptOfSaleCarousel.carousel("pause");
        }
    }
    /*2*/
    if($sendDetailCarousel.length)
    {
        if ($sendDetailCarousel.closest('section').hasClass('view'))
        {
            $ptOfSaleCarousel.carousel("pause");
            $apiMclCarousel.carousel("pause");
            $sendDetailCarousel.carousel("cycle");
        } else {     
            $sendDetailCarousel.carousel("pause");
        }
    }
    /*3*/
    if($apiMclCarousel.length)
    {

        if ($apiMclCarousel.closest('section').hasClass('view'))
        {
            $ptOfSaleCarousel.carousel("pause");
            $sendDetailCarousel.carousel("pause");
            $apiMclCarousel.carousel("cycle");
        } else {           
            $apiMclCarousel.carousel("pause");
        }
    }
}
var sliderTriggerTime=0,windowH=$(window).height();
$(window).on('load resize scroll',function() {
    checkSliders();
});
$(window).on('resize',function() {
    windowH=$(window).height();
});

//-------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------
function selectDirUpDown($dir,$elem,yPos){
    var firstLiIndex=$elem.find('.carousel-indicators li:first-child').index();
    var lastLiIndex=$elem.find('.carousel-indicators li:last-child').index();
    var activeLiIndex=$elem.find('.carousel-indicators li.active').index();
    if($dir) 
    {
        if(activeLiIndex > firstLiIndex)
        { 
            console.log('prev');
            $elem.find('.carousel-indicators li.active').prev('li').trigger('click');
        }
        else{
            console.log('prev-else',(yPos - windowH));
            $('html,body').animate({ scrollTop:  (yPos - $elem.outerHeight(true))}, 800);
            // window.scrollTo({top: (yPos - windowH) ,behavior: 'smooth'});
        }
    }
    else
    {
        if(activeLiIndex < lastLiIndex)
        {
            console.log('next');
            $elem.find('.carousel-indicators li.active').next('li').trigger('click');
        }
        else{
            console.log('next-else',(yPos + windowH));
            $('html,body').animate({ scrollTop:  (yPos + $elem.outerHeight(true))}, 800);
            // window.scrollTo({top: (yPos + windowH),behavior: 'smooth'});
        }
    }
}
// $('#ptOfSaleCarousel')
//     .on('mousewheel DOMMouseScroll', function(e){
//         e.preventDefault();
//         var $elem=$('#ptOfSaleCarousel'),elemH=$('#ptOfSaleCarousel').outerHeight();
//         var yPos=$elem.offset().top + $elem.outerHeight(true) /2 - windowH / 2;
//         var condn=(e.originalEvent.wheelDelta > 0 || e.originalEvent.detail < 0);
//         if(windowH >= elemH)
//         {//1 if
//             window.scrollTo({top: yPos,behavior: 'smooth'});
//             if(!sliderTriggerTime)
//             {//2 if
//                 selectDirUpDown(condn,$elem,yPos)
//                 sliderTriggerTime=1;
//                 setTimeout(function(){
//                     sliderTriggerTime=0;
//                 },600)
//             }//2 if
//         }//1 if
//     });
// $('#sendDetail')
//     .on('mousewheel DOMMouseScroll', function(e){
//         e.preventDefault();
//         var $elem=$('#sendDetail'),elemH=$('#sendDetail').outerHeight();
//         var yPos=$elem.offset().top + $elem.outerHeight(true) /2 - windowH / 2;
//         var condn=(e.originalEvent.wheelDelta > 0 || e.originalEvent.detail < 0);
//         if(windowH >= elemH)
//         {//1 if
//             window.scrollTo({top: yPos,behavior: 'smooth'});
//             if(!sliderTriggerTime)
//             {//2 if
//                 selectDirUpDown(condn,$elem,yPos)
//                 sliderTriggerTime=1;
//                 setTimeout(function(){
//                     sliderTriggerTime=0;
//                 },600)
//             }//2 if
//         }//1 if
//     });
// $('#apiMcl')
//     .on('mousewheel DOMMouseScroll', function(e){
//         e.preventDefault();
//         var $elem=$('#apiMcl'),elemH=$('#apiMcl').outerHeight();
//         var yPos=$elem.offset().top + $elem.outerHeight(true) /2 - windowH / 2;
//         var condn=(e.originalEvent.wheelDelta > 0 || e.originalEvent.detail < 0);
//         if(windowH >= elemH)
//         {//1 if
//             window.scrollTo({top: yPos,behavior: 'smooth'});
//             if(!sliderTriggerTime)
//             {//2 if
//                 selectDirUpDown(condn,$elem,yPos)
//                 sliderTriggerTime=1;
//                 setTimeout(function(){
//                     sliderTriggerTime=0;
//                 },600)
//             }//2 if
//         }//1 if
//     });
// jQuery(document).ready(function($){
//     $(".dropdown").on("hide.bs.dropdown", function(event){
//         // var x = $(event.relatedTarget).text(); // Get the button text
//         // alert("You clicked on: " + x);
//         console.log('dp-clickd');
//         $('.carousel-inner').removeClass('go-up');
//     });
//     $('.ptOfSale .giveItTryPopup,.sendDetail .giveItTryPopup,.apiMcl .giveItTryPopup ').on('click',function(){
        
//         console.log('clicked')
//     })  
// });