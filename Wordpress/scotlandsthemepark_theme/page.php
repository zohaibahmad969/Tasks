<?php
/* default page */
get_header();
//if ( is_page(38217) ) { get_header('orders'); } else { get_header(); }  ?>
<?php
	if (is_front_page()) { get_template_part('templates/page-home'); }
	else if (is_page(array(109,135))) { get_template_part('templates/page-grid'); }
	else if (is_page(array(1473))) { get_template_part('templates/page-sitemap'); }
	else if (is_page(array(3264))) { get_template_part('templates/page-process-order'); }
	//else if ( is_page(38217) ){ get_template_part('templates/page-orders'); }
	else { get_template_part('templates/page-default'); }
?>
<?php
get_footer();
//if ( is_page(38217) ) { get_footer('orders'); } else { get_footer(); }
?>