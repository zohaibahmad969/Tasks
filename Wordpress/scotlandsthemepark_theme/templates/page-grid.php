<div class="page-grid">
<?php rdsn_banner(); ?>
<div class="row-mid">

<div class="container">
<div class="sort-menu group">
	<ul class="height-menu">
	<?php
		$height_categories = get_categories('taxonomy=tax_ride_height&hide_empty=1');
		foreach($height_categories as $height_category):
			echo '<li data-filter=".'.$height_category->slug.'"><a href="#'.$height_category->slug.'" class="btn-solid trans-0-25">'.$height_category->name.'</a></li>';
		endforeach;
    ?>
    </ul>
    <ul class="rides-menu">
    <li class="btn-show-all-li active" data-filter="*"><a href="" onClick="return false;" class="btn-solid btn-show-all trans-0-25">All Rides</a></li>
	<?php
		$ride_categories = get_categories('taxonomy=tax_ride_type&hide_empty=1');
		foreach($ride_categories as $ride_category):
			echo '<li data-filter=".'.$ride_category->slug.'"><a href="#'.$ride_category->slug.'" class="btn-solid trans-0-25">'.$ride_category->name.'</a></li>';
		endforeach;
    ?>
    </ul>
</div>
</div>
	
<div id="grid-wrapper">
<!--<div class="container">-->
<div id="grid" class="group">
<?php
echo '<div class="grid-sizer"></div>';
echo '<div class="gutter-sizer"></div>';
echo '<div class="rides-wrapper">';
$gridItem = get_posts('numberposts=-1&offset=0&post_type=rdsn_ride&orderby=rand');
foreach($gridItem as $post) : setup_postdata($post);
	$title = get_the_title($post->ID);
	$excerpt = get_field('rdsn_custom_excerpt',$post->ID);
	if(!$excerpt) { $excerpt = custom_excerpt_foreach(20,$post->ID); }
	$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
	if ($image) { $image = $image[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
	$link = get_permalink($post->ID);
	$placeholder = '<img src="'.get_template_directory_uri().'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
	//
	$tax_ride_type_terms = get_the_terms( $post->ID, 'tax_ride_type' );
	$tax_ride_type_slug = array();
	foreach ( $tax_ride_type_terms as $term ) {
		$tax_ride_type_slug[] = $term->slug;
	}
	$ride_type_slug = join( " ", $tax_ride_type_slug );
	//
	$tax_ride_height_terms = get_the_terms( $post->ID, 'tax_ride_height' );
	$tax_ride_height_slug = array();
	foreach ( $tax_ride_height_terms as $term ) {
		$tax_ride_height_slug[] = $term->slug;
	}
	$ride_height_slug = join( " ", $tax_ride_height_slug );
	//
	echo '<div class="grid-item '.$ride_type_slug.' '.$ride_height_slug.'">';
		echo '<a href="'.$link.'">';
		echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
		echo '<div class="pop-content trans-0-3"><div class="vcenter-outer"><div class="vcenter-inner"><div class="pop-inner"><div class="title">'.$title.'</div><div class="excerpt">'.$excerpt.'</div><div class="btn-solid trans-0-25">Find out more</div></div></div></div></div>';
		echo '<div class="title-wrapper trans-0-3"><h3>'.$title.'</h3></div>';
		echo '<div class="pop-overlay trans-0-3"></div>';
		echo '<div class="overlay trans-0-3"></div>';
		echo '</a>';
	echo '</div>';
endforeach;
wp_reset_postdata();
echo '</div>';
?>
</div> 
<!--</div>-->
</div>

</div>
</div>