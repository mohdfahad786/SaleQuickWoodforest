jQuery(document).ready(function($){    $unformattednum = $('#et-info-phone').text();
    $formattednum = $unformattednum.replace(/-|\s/g,"");
    $("#et-info-phone").wrapInner("<a href=tel:" + $formattednum + "></a>");
    
    $('.et-social-icon a').attr('target','_blank');


    var menuItem = $('#top-menu > li > a');
    var menuItemBottomPadding = menuItem.innerHeight() - menuItem.height();
    var menuItemBorderHeight = 1
    var menuItemOffset = (menuItemBottomPadding * 65) / 100;
    var menuItemBottomValue = Math.abs(menuItemBottomPadding - menuItemOffset + menuItemBorderHeight);

    
    function ds_divi_switch_add_css(css) {
        var $style = jQuery('#ds-divi-switch-js-css');
        if (!$style.length) {
            $style = jQuery('<style id="ds-divi-switch-js-css">').appendTo('head');
        }
        $style.append(css);
    }

    if(typeof css !== 'undefined') {
        ds_divi_switch_add_css(css);
    }
    });
/*This file was exported by "Export WP Page to Static HTML" plugin which created by ReCorp (https://myrecorp.com) */