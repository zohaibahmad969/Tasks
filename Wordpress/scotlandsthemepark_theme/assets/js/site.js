jQuery(window).on('load',function(){
// -------------------------------- match height
jQuery('.rdsn-crsl .content').matchHeight();
jQuery('.woocommerce ul.products li.product').matchHeight();
})


jQuery(document).ready(function() {

// -------------------------------- banners

jQuery('#banner').cycle({   // moved to functions.php to allow for random element
	fx:'scrollHorz',
	speed:500,
	timeout:5000,
	slides:'> div',
	swipe: true,
	cycleLoader: true,
	easing: 'easeOutQuint',
	prev: '#banner-wrapper .btn-prev',
	next: '#banner-wrapper .btn-next',
	pauseOnHover:'#banner-wrapper .btn-prev,#banner-wrapper .btn-next'
});

var ban_num = jQuery('#banner div.slide').length;
if (ban_num == 1) {
    jQuery('#banner-wrapper .btn-prev,#banner-wrapper .btn-next').hide();
}

jQuery('#btn-wrapper').cycle({
	fx:'fade',
	speed:500,
	timeout:0,
	slides:'> div',
	//swipe: true,
	cycleLoader: true,
	easing: 'easeOutQuint'
});

jQuery('#banner').on('cycle-before', function() {
	jQuery('#btn-wrapper').cycle('next');
	//rdsn_tv.seekTo(0, true);   // moved to functions.php
});

jQuery('#slider').cycle({
	fx:'scrollHorz',
	speed:500,
	timeout:5000,
	slides:'> div',
	swipe: true,
	cycleLoader: true,
	easing: 'easeOutQuint',
	prev: '#slider-wrapper .btn-prev',
	next: '#slider-wrapper .btn-next',
	pauseOnHover:'#slider-wrapper .btn-prev,#slider-wrapper .btn-next'
});

var slide_num = jQuery('#slider div.slide').length;
if (slide_num == 1) {
    jQuery('#slider-wrapper .btn-prev, #slider-wrapper .btn-next').hide();
}


// -------------------------------- carousel
function rdsnCarousel(){
	var win_car_width = jQuery(window).width();
	var carousel_num = 5;
	if (win_car_width < 640) { carousel_num = 1; }
	else if (win_car_width >= 640 && win_car_width < 960) { carousel_num = 2; }
	else if (win_car_width >= 960 && win_car_width < 1500) { carousel_num = 3; }
	else { carousel_num = 5; }
	var n_car = jQuery('#rdsn-crsl div.grid-item').length;
	if (n_car > 5) {
		jQuery('#btn-crsl-prev, #btn-crsl-next').css('display','block');
		jQuery('#rdsn-crsl').cycle({	
		fx: 'carousel',
		carouselVisible: carousel_num,
		carouselFluid: true,
		speed: 700,
		timeout: 3000,
		swipe: true,
		slides:'> div',
		prev: '#btn-crsl-prev',
		next: '#btn-crsl-next',
		cycleLoader: true,
		easing: 'easeOutQuint'
	});
	}
}

rdsnCarousel();

// -------------------------------- Over-ride YITH Bokking select text
jQuery(document).ajaxComplete(function() {
	jQuery('.yith-wcbk-people-selector .yith-wcbk-people-selector__totals').text('select quantity');
});

// -------------------------------- Custom select and validation
jQuery('#department-menu .menu-item').on('click touchstart', function() {
	var index = jQuery('#department-menu .menu-item').index(this);
	jQuery('#department-row').val(index);
	var department = jQuery(this).text();
	jQuery('#department-menu .select-menu').slideUp();
	jQuery('#department-menu .selected').text(department);
	jQuery('#department-menu .selected').show();
});

jQuery('#department-menu .select-btn').on('click touchstart', function() {
	jQuery('#department-menu .selected').hide();
	jQuery('#department-menu .select-menu').slideDown();
});

jQuery("#contact-form").submit(function(e){
	if(jQuery('#department-row').val()=='') {
		alert ('Please select a department');
		e.preventDefault();
	}
});

jQuery(window).on('load',function(){
	jQuery('#department-row').val('');
});


// -------------------------------- accordion
jQuery('.list-item .row.top').click(function(){
	if (jQuery(this).parent().hasClass('open')) {
		jQuery(this).parent().removeClass('open')
	} else {		
		jQuery('.list-item .row.top').not(jQuery(this)).parent().removeClass('open');
		jQuery(this).parent().addClass('open');
		jQuery('html,body').delay(500).animate({ scrollTop: jQuery(this).offset().top -150 });
	}
});

jQuery(document).ajaxComplete(function() {
jQuery('.list-item .row.top').click(function(){
	if (jQuery(this).parent().hasClass('open')) {
		jQuery(this).parent().removeClass('open')
	} else {		
		jQuery('.list-item .row.top').not(jQuery(this)).parent().removeClass('open');
		jQuery(this).parent().addClass('open');
		//jQuery('html,body').delay(500).animate({ scrollTop: jQuery(this).offset().top -150 });
	}
});
});


// -------------------------------- email form
jQuery('#footer-signup .sign-up').on( 'click touchstart', function() {
	jQuery('#mc_embed_signup').addClass('open');
});


// -------------------------------- search modal
jQuery('#nav-search-wrapper').on( 'click touchstart', function(event) {
	event.preventDefault();
	jQuery('.rdsn-modal').addClass('open');
	jQuery('.rdsn-modal .fancybox-close-small').addClass('open');
	jQuery('.rdsn-modal .bg').addClass('open');
});

jQuery('#search-close').on( 'click touchstart', function(event) {
	event.preventDefault();
	jQuery('.rdsn-modal .bg').removeClass('open');
	setTimeout(function() {
    	jQuery('.rdsn-modal').removeClass('open');
  	}, 500);
});


// -------------------------------- responsive video
jQuery(".row-mid iframe").wrap("<div class='responsive-frame'/>");
jQuery(".row-mid iframe.tmjs-iframe").unwrap('.responsive-frame');

/*jQuery('iframe[src^="https://www.youtube.com"]').each(function() {
    var src = jQuery(this).attr('src');
    jQuery(this).attr('src', src + '&rel=0');
});*/


// -------------------------------- isotope
var $grid = jQuery('#grid').imagesLoaded( function() {
  // init Masonry after all images have loaded
	$grid.isotope({
		itemSelector: '.grid-item',
		percentPosition: true,
		masonry: {
    		columnWidth: '.grid-sizer',
  			gutter: '.gutter-sizer'
  		}
	});
	var hash = window.location.hash.substr(1);
	jQuery('.sort-menu li[data-filter=".'+hash+'"] a').trigger('click');
});

jQuery('.sort-menu ul li').on( 'click touchstart', function() {
    var filterValue = jQuery(this).attr('data-filter');
	var hashValue = filterValue.substring(1);
    jQuery('#grid').isotope({ filter: filterValue });
	//window.location.hash = '#'+hashValue;
});

jQuery('.sort-menu > ul > li').on( 'click touchstart', function() {
	jQuery('.sort-menu ul li').removeClass('active');
	jQuery(this).addClass('active');
});


// -------------------------------- fades
jQuery('.fade-in').each(function() {
	jQuery(this).waypoint(function(direction) {
		if (direction === 'down') {
			jQuery(this.element).addClass('fadeIn');
			jQuery(this.element).removeClass('fadeOut');
		}
		if (direction === 'up') {
			jQuery(this.element).addClass('animated fadeOut');
			jQuery(this.element).removeClass('fadeIn');
		}
	}, {
		offset: '95%'
	});
});

jQuery('.anim-up').each(function() {
	jQuery(this).waypoint(function(direction) {
		if (direction === 'down') {
			jQuery(this.element).addClass('fadeInUp');
			jQuery(this.element).removeClass('fadeOutDown');
		}
		if (direction === 'up') {
			jQuery(this.element).addClass('animated fadeOutDown');
			jQuery(this.element).removeClass('fadeInUp');
		}
	}, {
		offset: '95%'
	});
});

jQuery(document).ajaxComplete(function() {
jQuery('.fade-in').each(function() {
	jQuery(this).waypoint(function(direction) {
		if (direction === 'down') {
			jQuery(this.element).addClass('fadeIn');
			jQuery(this.element).removeClass('fadeOut');
		}
		if (direction === 'up') {
			jQuery(this.element).addClass('animated fadeOut');
			jQuery(this.element).removeClass('fadeIn');
		}
	}, {
		offset: '95%'
	});
});
});

jQuery(document).ajaxComplete(function() {
jQuery('.anim-up').each(function() {
	jQuery(this).waypoint(function(direction) {
		if (direction === 'down') {
			jQuery(this.element).addClass('fadeInUp');
			jQuery(this.element).removeClass('fadeOutDown');
		}
		if (direction === 'up') {
			jQuery(this.element).addClass('animated fadeOutDown');
			jQuery(this.element).removeClass('fadeInUp');
		}
	}, {
		offset: '95%'
	});
});
});

    
    
// -------------------------------- Mailchimp link
jQuery("#chimp-link").on('click touchstart', function(e) {
	e.preventDefault();	
	jQuery('#footer-signup').show();
	jQuery('#nav-mobile,#nav-icon').removeClass('open');
	jQuery('#mc_embed_signup').addClass('open');
	jQuery('html,body').animate({ scrollTop: jQuery("#footer-signup").offset().top -75 });	
});
    
    

// -------------------------------- on page scroll
jQuery(function() {
    var offset = jQuery('body');
	var mast = jQuery('#header');
    var navHomeY = mast.offset().top;
    var isFixed = false;
    var win = jQuery(window);
    win.scroll(function() {
        var scrollTop = win.scrollTop();
        var shouldBeFixed = scrollTop > navHomeY;
        if (shouldBeFixed && !isFixed) {
			offset.addClass('scrolling');
			mast.addClass('scrolling');
            isFixed = true;
        }
        else if (!shouldBeFixed && isFixed)
        {
			offset.removeClass('scrolling');
			mast.removeClass('scrolling');
            isFixed = false;
        }
    });
});




jQuery(window).on("load resize", function(){
	rdsnFooterSites();
});

function rdsnFooterSites(){
var win_width = jQuery(window).width();
if (win_width >= 640) {
	jQuery('#footer-sites .grid-item').on( 'click touchstart', function(event) {
		jQuery('#footer-sites .grid-item .tab').removeClass('open');
		jQuery(this).find('.tab').addClass('open');
	});
} else {
	jQuery('#footer-sites .grid-item .title').on( 'click', function(event) {
		var $this_link = jQuery(this).parent().parent().parent().find('.tab a').attr('href');
		var $this_target = jQuery(this).parent().parent().parent().find('.tab a').attr('target');
		window.open($this_link, $this_target);
	});
}
}

jQuery('html').on( 'click touchstart', function(e){
	jQuery('#footer-sites .grid-item .tab').removeClass('open');
});

jQuery('#footer-sites .grid-item').on( 'click touchstart', function(e){
    e.stopPropagation();
});



// -------------------------------- search validation
jQuery("#searchform").validate({
	rules: {
        s: "required"
    }
});


// -------------------------------- contact form validation
jQuery("#contact-form").validate({
		ignore: [],
		rules: {
			name: "required",
			email: {
				required: true,
				email: true
			}
		}
});

jQuery("#amazonia-contact-form").validate({
		ignore: [],
		rules: {
			name: "required",
			email: {
				required: true,
				email: true
			}
		}
});

jQuery(function() {
    if ( document.location.href.indexOf('#contact-complete') > -1 ) {
		jQuery('html,body').animate({ scrollTop: jQuery(".row-mid").offset().top -200 });
		jQuery('#contact-complete').show('fast');
    }
});


// -------------------------------- woo
//jQuery('.yith-wcbk-form-section-dates label').text('Select a date');
//jQuery('.yith-wcbk-form-section-dates.yith-wcbk-form-section-dates-date-time label').text('Select a time');

jQuery(".woocommerce-checkout table.shop_table td.booking-id a").each(function(){
	jQuery(this).removeAttr("href");
});

jQuery('#book-now').on( 'click', function(e) {
	e.preventDefault();
	jQuery('html, body').animate({ scrollTop: jQuery(".rdsn-product-wrapper form.cart").offset().top -200 });
});


// end doc ready
});


// -------------------------------- functions
jQuery.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        jQuery(this).addClass('animated ' + animationName).one(animationEnd, function() {
            jQuery(this).removeClass('animated ' + animationName);
        });
    }
});


//// NAV
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
    

