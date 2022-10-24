<?php
$show_events = get_field('rdsn_show_events','option');
if($show_events == 'no') {
	if ( is_page(113) || is_singular('rdsn_event') || is_shop() || is_product() ) {
		$current_user = wp_get_current_user();
    	if (!user_can( $current_user, 'administrator' )) { // user is not an admin
      		$url = get_home_url();
			wp_redirect( $url );
			exit;
    	}
	}
}
?>
<!doctype html>
<html lang="en">
<head>
<?php rdsn_meta_title() ?>
<?php rdsn_meta_description() ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<link rel="stylesheet" href="https://use.typekit.net/fft6bzo.css">
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/animate.css" rel="stylesheet" type="text/css">
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/select2.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo get_template_directory_uri(); ?>/assets/style/site.css?ver=1.00<?php echo $_SERVER['REQUEST_TIME'] ?>" rel="stylesheet" type="text/css">    
    
<?php if(isset ($_GET['mdsapp']) && $_GET['mdsapp']=='true'): ?>
	<style>.rdsn-modal, #header, #nav-mobile, #content-offset, #footer-top, #footer-social, #footer-signup, #footer-contact, #footer-sites, #offset-footer, .btn-back, .back-link {display:none;} .fade-in,.anim-up {opacity:1;}</style>
<?php endif; ?>
    
<meta property="og:locale" content="en_GB" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php rdsn_meta_og_title() ?>" />
<meta property="og:description" content="<?php rdsn_meta_og_description() ?>" />
<meta property="og:url" content="<?php echo get_permalink(); ?>" />
<meta property="og:image" content="<?php rdsn_meta_og_image() ?>" />
<meta property="og:site_name" content="<?php rdsn_meta_og_site_name() ?>" />
    
<?php wp_head(); ?>

<!-- Google Analytics - from previous site -->
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	ga('create', 'UA-3900949-1', 'scotlandsthemepark.com');
	ga('send', 'pageview');	
</script>
</head>

<body <?php body_class(); ?>>
        
<!-- start search modal -->
<div class="rdsn-modal">
<div class="bg trans-0-3">
<div class="container">
<div class="vcenter-outer">
<div class="vcenter-inner">
	<div id="search-title">Search Scotland's Theme Park</div>
    <div id="search-form" class="trans-0-25">
		<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="text" class="input" value="<?php echo get_search_query(); ?>" name="s" id="s" />
            <input type="submit" class="btn-submit trans-0-3" id="searchsubmit" value="&nbsp;">
		</form>
	</div>
    <a href="#" id="search-close" class="trans-0-3">Close</a>
</div>
</div>
</div>
</div>
</div>
<!-- end search modal -->
<div id="header" class="trans-0-5">
	<a href="/" class="logo-main trans-0-5"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-scotlands-theme-park.png" alt="M&D's - Scotland's Theme Park" class="logo-desktop" /><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-scotlands-theme-park-mobile.png" alt="M&D's - Scotland's Theme Park" class="logo-mobile" /></a>
    <div id="social-top"><?php rdsn_social(); ?></div>
    <div id="nav-icon-wrapper" class="trans-0-3"><div id="nav-icon"><span></span><span></span><span></span><span></span></div><div id="nav-icon-text">menu</div></div>
    <!--<a id="nav-cart-wrapper" class="trans-0-3" href="/basket/"><div id="nav-cart-text"><div class="top">Basket</div><div class="btm"><?php //$cart_count = WC()->cart->get_cart_contents_count(); echo  '<div class="cart-totals"><span>'.$cart_count.'</span> items</div>';?></div></div></a>-->
    <a id="nav-ticket-wrapper" class="trans-0-3" href="<?php the_field('header_button_url','option'); ?>"><div id="nav-ticket-text"><div class="top">buy</div><div class="btm">tickets</div></div><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-ticket.png" alt="Scotland's Theme Park - Buy Tickets" class="icon-ticket" /></a>
    <!--<a id="nav-ticket-wrapper" class="trans-0-3" href="/store/"><div id="nav-ticket-text"><div class="top">buy</div><div class="btm">tickets</div></div><img src="<?php //echo get_template_directory_uri(); ?>/assets/img/icon-ticket.png" alt="Scotland's Theme Park - Buy Tickets" class="icon-ticket" /></a>-->
    <a id="nav-search-wrapper" class="trans-0-3" href="#"><div id="nav-search-text" class="trans-0-3">search</div><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-search.png" alt="Search Scotland's Theme Park" class="icon-search trans-0-3" /><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-search-02.png" alt="Search Scotland's Theme Park" class="icon-search-02 trans-0-3" /></a></a>
</div>
<?php $cart_count = WC()->cart->get_cart_contents_count(); if($cart_count > 0): ?>
<a id="nav-cart-wrapper" class="trans-0-3" href="/basket/"><div id="nav-cart-text"><div class="top">Basket</div><div class="btm"><?php echo '<div class="cart-totals"><span>'.$cart_count.'</span> items</div>';?></div></div></a>
<?php endif; ?>
<div id="nav-mobile" class="nav-mobile md-main-menu"><?php  wp_nav_menu(   
        array ( 
            'container'      => FALSE,
            'theme_location' => 'md_main_menu' 
         ) 
    );  ?></div>
<div id="content-offset"></div>
    

    