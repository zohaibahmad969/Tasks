<div class="page-sitemap">
    <div class="row-mid">
    <div class="container group">
	
 
<h2 style="padding-top:70px;">Calendar</h2>
 
<script
  src="https://www.universe.com/embed2.js"
  data-widget-type="universe-calendar"
  data-target-type="user"
  data-target-id="5d78ced03a10800051f56c1e"
  data-state="buttonColor=#3A66E5&buttonText=Get Tickets" >
</script>
 
<h3>Tickets</h3>
 
<script
  src="https://www.universe.com/embed2.js"
  data-widget-type="universe-ticket"
  data-target-type="Listing"
  data-target-id="test-tickets-L9VPFC"
  data-state="buttonColor=#3A66E5&buttonText=Get Tickets" >
</script>

<?php
/*$args = array(
  'post_type' => 'page',
  'posts_per_page' => -1,
  'exclude' => 2
);
$wp_query = NULL;
$wp_query = new WP_Query();
$wp_query->query($args);
if ($wp_query->have_posts()) {
	while ($wp_query->have_posts()):$wp_query->the_post();
		$title = get_the_title();	
		$id = get_the_ID();
		echo '<div>'.$title.' - '.$id.'</div>';
	endwhile;
$wp_query = NULL;
wp_reset_postdata();
}*/
/*global $post;
$args = array('title_li' => '','sort_column'  => 'menu_order','echo' => 0,'link_after'   => get_the_ID($post->ID));
$pages = wp_list_pages($args);
echo '<ul id="site-map">'.$pages.'</ul>';*/
?>

<!--<script type="text/javascript">
jQuery(document).ready(function() {
	//var className = [];
	jQuery('#site-map li').each(function(event) {
  		event.stopPropagation
		var className = jQuery(this).attr('class');
		//var lastClass = className.lastIndexOf('page-item');
		//jQuery(this).click(function(e) {
			//e.preventDefault();
			//alert(className);
		//});
		jQuery(this).append(' - ' + className);
		//jQuery(this).append('asdasdasd - ');
	});
});
</script>-->
<style>
#site-map ul {padding-left:40px;}
</style>
   
    </div>
    </div>
</div>