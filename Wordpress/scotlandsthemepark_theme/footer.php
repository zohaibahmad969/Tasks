<?php if (!is_front_page()): ?>
<?php footer_box_type(); ?>
<div id="footer-social">
<div class="container">
	<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-scotlands-theme-park-footer.png" alt="M&D's - Scotland's Theme Park" class="logo-footer animated anim-up" />
</div>
</div>
<?php endif; ?>

<?php
  include get_template_directory().'/includes/mailing-list.php'; 
?>

<?php if (!is_front_page()): ?>
<div id="footer-contact">
<div class="container">
	<div class="address"><?php the_field('ftr_address','option'); ?></div>
    <ul class="contact"><li>Tel: <?php $phone = get_field('ftr_telephone','option'); $phone_link = str_replace(' ', '', $phone); echo '<a href="tel:'.$phone_link.'" class=" trans-0-3">'.$phone.'</a>'; ?></li><li>Email : <?php $email = get_field('ftr_email','option'); echo '<a href="mailto:'.antispambot($email).'" class="trans-0-3">'.antispambot($email).'</a>'; ?></li></ul>
    <div id="social-btm"><?php rdsn_social(); ?></div>
    <div class="footer-links"><?php footerLinks(); ?></div>
</div>
</div>
<?php endif; ?>
<?php rdsn_attractions(); ?>

<div id="offset-footer"></div>

<?php
$show_events = get_field('rdsn_show_events','option');
if($show_events == 'no') {
	$current_user = wp_get_current_user();
    if (!user_can( $current_user, 'administrator' )) { // user is not an admin
        echo '<style>#nav-mobile li.page-item-113 {display:none;}</style>';
    }
}
?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.cycle2.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.cycle2.swipe.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.cycle2.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.matchHeight-min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/site.js?ver=1.04<?php echo $_SERVER['REQUEST_TIME'] ?>"></script>

<!--<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/nav.js?ver=1.04<?php echo $_SERVER['REQUEST_TIME'] ?>"></script>-->


<?php wp_footer(); ?>
<!--<input id="rdwidgeturl" name="rdwidgeturl" value="https://booking.resdiary.com/widget/Standard/MDsScotlandsThemePark/24094?includeJquery=false" type="hidden">
<script type="text/javascript" src="https://booking.resdiary.com/bundles/WidgetV2Loader.js"></script>-->
</body>
</html>

