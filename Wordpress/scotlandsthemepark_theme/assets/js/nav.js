

jQuery(document).ready(function() {
    
    // burger menu toggle    
    jQuery('#nav-icon-wrapper,#nav-icon,#nav-mobile').on( 'click touchstart', function(e){e.stopPropagation();});
    jQuery('#nav-icon-wrapper,#nav-icon').on('click', function(e) {  
        e.preventDefault();jQuery('#nav-icon').toggleClass('open');	jQuery('#nav-mobile').toggleClass('open');
    });    
    
    jQuery('#nav-mobile > ul > li > a').on( 'click touchstart', function(event) {
        let childMenu = (jQuery(this).closest('li').find('ul').children().length > 0);
        if(!childMenu) {return true;} else {
             event.preventDefault();
             jQuery('#nav-mobile > ul > li > a').not(this).next('ul').removeClass('open');
             jQuery('#nav-mobile > ul > li > a').not(this).next('ul').css('max-height','0');
             jQuery(this).next('ul').css('max-height','888px');
             jQuery(this).next('ul').addClass('open');
        }
    });
    
});
    
    
    /*
    jQuery('html').on( 'click touchstart', function(){
        jQuery('#nav-icon-wrapper').removeClass('open');
        jQuery('#nav-icon').removeClass('open'); jQuery('#nav-mobile').removeClass('open');
    });    */

    

    // -------------------------------- reset mobile nav button and menu

//    if ("ontouchstart" in document.documentElement) {
//
//    jQuery('.sub-menu > ul > li > a').on( 'click touchstart', function(event) {
//
//        if(jQuery(this).closest('li').find('ul').children().length == 0) {
//                return true;
//            } else {
//        jQuery('.sub-menu > ul > li > a').not(this).next('ul').removeClass('open');
//        jQuery(this).next('ul').addClass('open');
//        event.preventDefault();
//        }
//    });
//    }
//

//    jQuery(function() {  
//        var nav_btn = jQuery('#nav-sub-icon'); 
//        var nav_menu = jQuery('#nav-sub-menu');
//        jQuery(nav_btn).on('click touchstart', function(e) {  
//            e.preventDefault();
//            console.log('DDDD');
//            jQuery(nav_btn).toggleClass('open');
//            nav_menu.toggleClass('open');
//        });
//    });

    
    
