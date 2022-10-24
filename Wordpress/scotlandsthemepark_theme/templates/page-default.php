<div class="page-default">
<?php rdsn_banner(); ?>	
<?php global $post; if (is_page(143) || in_array(143, get_ancestors($post->ID, 'page'))) { menu_amazonia(); } ?>
    <div class="row-mid">
    <?php if (is_page(102)) { rdsn_calendar(); } ?>
	<?php if (is_page(array(111,115,117,119,168))) { rdsn_child_pages(); } ?>
    <?php if (is_page(371) || $post->post_parent == 371) { rdsn_amazonia_animals_child_pages(); } // upper level amazonia species pages grid list ?>
    <?php if (is_page(array(373,379,382)) || in_array($post->post_parent,array(373,379))) { rdsn_amazonia_lower_pages(); } // lower level amazonia pages etc grid list ?> 
	<?php if (is_page(113)) { get_events(); } ?>
    <?php if (is_page(462)) { get_offers(); } ?>
    <?php if (is_page(array(137,139,141))) { get_rides(); }?>   
    <div class="container group">
    	<?php if ( in_array($post->post_parent,array(925,927,929,931,933,935,937)) || is_page(array(947,949,961,965,976,978,1661,1665)) ) { rdsn_gallery_fixed(); } ?>
		<?php if ( in_array($post->post_parent,array(168,925,927,929,931,933,935,937)) || is_page(array(170,947,949,961,965,1661)) ) { echo '<div class="col-left">'; } ?>
			<?php if ( in_array($post->post_parent,array(925,927,929,931,933,935,937)) || is_page(array(947,949)) ) { echo '<h1 class="reduced-pad">'; rdsn_custom_title(); echo '</h1>'; } ?>
            <?php if ( is_page(array(965,976,978,1661)) ) { echo '<h1>'; rdsn_custom_title(); echo '</h1>'; } ?>
			<?php if(is_page(array(123,957))) { rdsn_contact_thanks(); } ?>
            	<?php if (have_posts()): while (have_posts()) : the_post(); the_content(); endwhile; endif; ?>
            <?php offers_rows(); ?>
            <?php if(is_page(array(655,941))) { rdsn_map(); } ?>
            <?php if(is_page(array(957))) { amazonia_contact(); } ?>
            <?php if ( $post->post_parent=='168' ){ child_menu(); } ?>
    	</div>
    	<div class="col-right">
    		<?php side_boxes(); ?>
    	<?php if ( in_array($post->post_parent,array(168,925,927,929,931,933,935,937)) || is_page(array(170,947,949,961,965,1661))  ){ echo '</div>'; } ?>
    </div>
    <?php if (is_page(955)) { get_restaurants(); } // Amazonia - Eating & Drinking ?>
    </div>
</div>
<?php if ( is_page(143)) { echo '<style>.sub-menu ul li:first-child a, #nav-sub-menu ul li:first-child a {color:#FFCA44;}</style>'; }?>



<?php //global $post; if ( $post->post_parent=='111' ){ rdsn_attraction_ot(); } ?>
<?php //if (is_page(102)) { rdsn_attractions_ot(); rdsn_food_drink_ot(); } ?>
<?php //if (is_page(array(373))) { rdsn_amazonia_lower_pages(); } // upper level amazonia general pages grid list ?>