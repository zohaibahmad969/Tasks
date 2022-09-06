<?php


add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
?>
<script type="text/javascript">
	jQuery(document).ready(function( $ ){
		$("#keyword").keyup(function(){
			$.ajax({
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				type: 'post',
				data: { action: 'data_fetch', keyword: $('#keyword').val() },
				success: function(data) {
					jQuery('#datafetch').html( data );
				}
			});		
		});
	});
</script>

<?php
}


add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){

    $the_query = new WP_Query( 
      array( 
        'posts_per_page' => -1, 
        's' => esc_attr( $_POST['keyword'] ), 
        'post_type' => 'projects' 
      ) 
    );


    if( $the_query->have_posts() ) :
		?> <div class="za-items"> <?php
        	while( $the_query->have_posts() ): $the_query->the_post();

			$myquery = esc_attr( $_POST['keyword'] );
			$search = get_the_title();
			if( stripos("/{$search}/", $a) !== false) {
			?>
				<div class="za-item">
					<a href="<?php echo esc_url( post_permalink() ); ?>">
						<img class="za-item-img" src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full') ?>">						</a>
					<h4 class="za-item-title">
						<a href="<?php echo esc_url( post_permalink() ); ?>"><?php the_title();?></a>
					</h4>
				</div>
        	<?php                                  }
    		endwhile;
		?></div><?php
        wp_reset_postdata();  
    endif;

    die();
}
