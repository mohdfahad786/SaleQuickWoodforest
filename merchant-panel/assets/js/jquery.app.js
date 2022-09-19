/**
 * Theme: Minton Admin Template
 * Author: Coderthemes
 * Module/App: Main Js
 */


! function($) {
    "use strict";

    var Sidemenu = function() {
        this.$body = $("body"),
            this.$openLeftBtn = $(".open-left"),
            this.$menuItem = $("#sidebar-menu a")
    };
    Sidemenu.prototype.openLeftBar = function() {
            $("#wrapper").toggleClass("enlarged");
            $("#wrapper").addClass("forced");

            if ($("#wrapper").hasClass("enlarged") && $("body").hasClass("fixed-left")) {
                $("body").removeClass("fixed-left").addClass("fixed-left-void");
            } else if (!$("#wrapper").hasClass("enlarged") && $("body").hasClass("fixed-left-void")) {
                $("body").removeClass("fixed-left-void").addClass("fixed-left");
            }

            if ($("#wrapper").hasClass("enlarged")) {
                $(".left ul").removeAttr("style");
            } else {
                $(".subdrop").siblings("ul:first").show();
            }

            toggle_slimscroll(".slimscrollleft");
            $("body").trigger("resize");
        },
        //menu item click
        Sidemenu.prototype.menuItemClick = function(e) {
            if (!$("#wrapper").hasClass("enlarged")) {
                if ($(this).parent().hasClass("has_sub")) {

                }
                if (!$(this).hasClass("subdrop")) {
                    // hide any open menus and remove all other classes
                    $("ul", $(this).parents("ul:first")).slideUp(350);
                    $("a", $(this).parents("ul:first")).removeClass("subdrop");
                    $("#sidebar-menu .pull-right i").removeClass("md-remove").addClass("md-add");

                    // open our new menu and add the open class
                    $(this).next("ul").slideDown(350);
                    $(this).addClass("subdrop");
                    $(".pull-right i", $(this).parents(".has_sub:last")).removeClass("md-add").addClass("md-remove");
                    $(".pull-right i", $(this).siblings("ul")).removeClass("md-remove").addClass("md-add");
                } else if ($(this).hasClass("subdrop")) {
                    $(this).removeClass("subdrop");
                    $(this).next("ul").slideUp(350);
                    $(".pull-right i", $(this).parent()).removeClass("md-remove").addClass("md-add");
                }
            }
        },

        //init sidemenu
        Sidemenu.prototype.init = function() {
            var $this = this;

            var ua = navigator.userAgent,
                event = (ua.match(/iP/i)) ? "touchstart" : "click";

            //bind on click
            this.$openLeftBtn.on(event, function(e) {
                e.stopPropagation();
                $this.openLeftBar();


            });

            // LEFT SIDE MAIN NAVIGATION
            $this.$menuItem.on(event, $this.menuItemClick);

            // NAVIGATION HIGHLIGHT & OPEN PARENT
            $("#sidebar-menu ul li.has_sub a.active").parents("li:last").children("a:first").addClass("active").trigger("click");
        },

        //init Sidemenu
        $.Sidemenu = new Sidemenu, $.Sidemenu.Constructor = Sidemenu

}(window.jQuery),


function($) {
    "use strict";

    var FullScreen = function() {
        this.$body = $("body"),
            this.$fullscreenBtn = $("#btn-fullscreen")
    };

    //turn on full screen
    // Thanks to http://davidwalsh.name/fullscreen
    FullScreen.prototype.launchFullscreen = function(element) {
            if (element.requestFullscreen) {
                element.requestFullscreen();
            } else if (element.mozRequestFullScreen) {
                element.mozRequestFullScreen();
            } else if (element.webkitRequestFullscreen) {
                element.webkitRequestFullscreen();
            } else if (element.msRequestFullscreen) {
                element.msRequestFullscreen();
            }
        },
        FullScreen.prototype.exitFullscreen = function() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        },
        //toggle screen
        FullScreen.prototype.toggle_fullscreen = function() {
            var $this = this;
            var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;
            if (fullscreenEnabled) {
                if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
                    $this.launchFullscreen(document.documentElement);
                } else {
                    $this.exitFullscreen();
                }
            }
        },
        //init sidemenu
        FullScreen.prototype.init = function() {
            var $this = this;
            //bind
            $this.$fullscreenBtn.on('click', function() {
                $this.toggle_fullscreen();
            });
        },
        //init FullScreen
        $.FullScreen = new FullScreen, $.FullScreen.Constructor = FullScreen

}(window.jQuery),



//main app module
function($) {
    "use strict";

    var App = function() {
        this.VERSION = "2.0.0",
            this.AUTHOR = "Coderthemes",
            this.SUPPORT = "coderthemes@gmail.com",
            this.pageScrollElement = "html, body",
            this.$body = $("body")
    };

    //on doc load
    App.prototype.onDocReady = function(e) {
            // FastClick.attach(document.body);
            // resizefunc.push("initscrolls");
            // resizefunc.push("changeptype");

            $('.animate-number').each(function() {
                $(this).animateNumbers($(this).attr("data-value"), true, parseInt($(this).attr("data-duration")));
            });

            //RUN RESIZE ITEMS
            $(window).resize(debounce(resizeitems, 100));
            $("body").trigger("resize");

            // right side-bar toggle
            $('.right-bar-toggle').on('click', function(e) {

                $('#wrapper').toggleClass('right-bar-enabled');
            });


        },
        //initilizing 
        App.prototype.init = function() {
            var $this = this;
            //document load initialization
            $(document).ready($this.onDocReady);
            //init side bar - left
            $.Sidemenu.init();
            //init fullscreen
            $.FullScreen.init();
        },

        $.App = new App, $.App.Constructor = App

}(window.jQuery),

//initializing main application module
function($) {
    "use strict";
    $.App.init();
}(window.jQuery);



/* ------------ some utility functions ----------------------- */
//this full screen
var toggle_fullscreen = function() {

}

function executeFunctionByName(functionName, context /*, args */ ) {
    var args = [].slice.call(arguments).splice(2);
    var namespaces = functionName.split(".");
    var func = namespaces.pop();
    for (var i = 0; i < namespaces.length; i++) {
        context = context[namespaces[i]];
    }
    return context[func].apply(this, args);
}
var w, h, dw, dh;
var changeptype = function() {
    w = $(window).width();
    h = $(window).height();
    dw = $(document).width();
    dh = $(document).height();

    if (jQuery.browser.mobile === true) {
        $("body").addClass("mobile").removeClass("fixed-left");
    }

    if (!$("#wrapper").hasClass("forced")) {
        if (w > 1024) {
            $("body").removeClass("smallscreen").addClass("widescreen");
            $("#wrapper").removeClass("enlarged");
        } else {
            $("body").removeClass("widescreen").addClass("smallscreen");
            $("#wrapper").addClass("enlarged");
            $(".left ul").removeAttr("style");
        }
        if ($("#wrapper").hasClass("enlarged") && $("body").hasClass("fixed-left")) {
            $("body").removeClass("fixed-left").addClass("fixed-left-void");
        } else if (!$("#wrapper").hasClass("enlarged") && $("body").hasClass("fixed-left-void")) {
            $("body").removeClass("fixed-left-void").addClass("fixed-left");
        }

    }
    toggle_slimscroll(".slimscrollleft");
}


var debounce = function(func, wait, immediate) {
    var timeout, result;
    return function() {
        var context = this,
            args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) result = func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) result = func.apply(context, args);
        return result;
    };
}

function resizeitems() {
    if ($.isArray(resizefunc)) {
        for (i = 0; i < resizefunc.length; i++) {
            window[resizefunc[i]]();
        }
    }
}

function initscrolls() {
    if (jQuery.browser.mobile !== true) {
        //SLIM SCROLL
        $('.slimscroller').slimscroll({
            height: 'auto',
            size: "5px"
        });

        $('.slimscrollleft').slimScroll({
            height: 'auto',
            position: 'right',
            size: "5px",
            color: '#98a6ad',
            wheelStep: 5
        });
    }
}

function toggle_slimscroll(item){
    if ($("#wrapper").hasClass("enlarged")) {
        $(item).css("overflow", "inherit").parent().css("overflow", "inherit");
        $(item).siblings(".slimScrollBar").css("visibility", "hidden");
    } else {
        $(item).css("overflow", "hidden").parent().css("overflow", "hidden");
        $(item).siblings(".slimScrollBar").css("visibility", "visible");
    }
}
function validateMerchantApi($wrapper){
var emailRegx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;// Email address
var phone = /[0-9]/;// Email address
var trueFalse= 1;
$wrapper.find('.required').each(function(){

var tabIndx=$(this).closest('.tab-pane').index();
var tabLngth=$wrapper.find('.tab-pane').length - 1;
var goNext=false;

var $triggerTab='';


$triggerTab=$wrapper.find('.nav-tabs .nav-item .nav-link').eq(tabIndx).attr('href');

console.log($triggerTab);

var txtVal=$(this).val();
// console.log(txtVal)
//check empty
if(!txtVal.length)
{
// console.log('run')
$(this).closest('.form-group').addClass('mandatory');
$('.nav-tabs a[href="' + $triggerTab + '"]').tab('show');
$(this).focus();
trueFalse=0;
return false;
}
//check if email
if($(this).hasClass('email'))
{
if(!emailRegx.test(txtVal))
{
$(this).closest('.form-group').addClass('incorrect');
$('.nav-tabs a[href="' + $triggerTab + '"]').tab('show');
$(this).focus();
trueFalse=0;
return false;
}
}
})
return trueFalse;
}
function getWholeData($wrapper){
var wholeData= {};
$('#activation_dynamic-content1 .required,#activation_dynamic-content1 .hidden_inputs').each(function(){
var txtVal=$(this).val();
if($(this).hasClass('us-phone-no')){
txtVal=txtVal.replace(/[\(\)-\s]/g,'');
}
else if($(this).hasClass('us-ssn-no-enc')){
txtVal=$(this).data('val'); 
}
wholeData[$(this).attr('id')]=txtVal;
})
// console.log(wholeData);

return wholeData;
}
// === following js will activate the menu in left side bar based on url ====
$(document).ready(function() {
    // $("#sidebar-menu a").each(function() {
    //     if (this.href == window.location.href) {
    //         $(this).addClass("active");
    //         $(this).parent().addClass("active"); // add active to li of the current link
    //         $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
    //         $(this).parent().parent().parent().parent().prev().click();
    //         $(this).parent().parent().prev().click(); // click the item to make it drop
    //     }
    // });

    donutTooltip = {
        borderWidth: 0,
        backgroundColor: 'none',
        shadow: false,
        style: {
            fontSize: '20px'
        },
        pointFormat: '<span style="font-size:2em; display:inline-block;width:100%;color: {point.color}; font-weight: bold">{point.y}<span style="font-size: 1.4em;color:{point.color}">%</span></span>',
        positioner: function (labelWidth) {
            return {
                x: 90 - labelWidth / 2,
                y: 155
            };
        }
    };

    donutPane = {
        startAngle: 0,
        endAngle: 360,
        background: [{ // Track for Move
            outerRadius: '116%',
            innerRadius: '84%',
            backgroundColor: {
                radialGradient:  { cx: 0.5, cy: 0.5, r: 0.5 },
                stops: [
                    [0, '#7CB5EC'], //green
                    [1, 'rgba(121,174,239,0.05)'] //yellow
                ]
            },
            borderWidth: 0
        }]
    };
    // $('.us-date-calendar').datepicker({
    //     toggleActive: true,
    //     format: "yyyy-mm-dd",
    //     setDate: $(this).val()
    // });
});

