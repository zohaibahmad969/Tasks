<!-- Slider main container -->
		<div class="swiper wpkd-post-grid-slider">
		  <!-- Additional required wrapper -->
		  <div class="swiper-wrapper">
<?php 
while ( $all_posts->have_posts() ) :

    $all_posts->the_post(); ?>
	<div class="swiper-slide">
        <article id="post-<?php the_ID(); ?>" <?php post_class('wpkd-post'); ?>>
         
            <div class="post-grid-inner">
                
                <?php $this->render_thumbnail(); ?>

                <div class="post-grid-text-wrap">
                    <?php $this->render_title(); ?>
                    <?php $this->render_meta(); ?>
					<?php $this->render_person_position(); ?>
					 <?php $this->render_author_box(); ?>
                    <?php $this->render_excerpt(); ?>
                    <?php $this->render_readmore(); ?>
                </div>

            </div><!-- .blog-inner -->
           
        </article>
</div>
        <?php

endwhile;  
?>
</div>
<!-- If we need pagination -->
		  <div class="swiper-pagination"></div>
</div>
<?php
wp_reset_postdata();
?>
<script>
jQuery( function( $ ) {
// add 'swiper-container' class to .elementor-container
const swiper = new Swiper('.swiper', {
	  // Default parameters
	  slidesPerView: 3,
	  spaceBetween: 30,
	  loop: true,
	  autoplay: true,

	  // If we need pagination
	  pagination: {
		el: '.swiper-pagination',
	  },
	  // Responsive breakpoints
	  breakpoints: {
		// when window width is >= 320px
		320: {
		  slidesPerView: 2,
		  spaceBetween: 20
		},
		// when window width is >= 480px
		480: {
		  slidesPerView: 3,
		  spaceBetween: 30
		},
		// when window width is >= 640px
		640: {
		  slidesPerView: 3,
		  spaceBetween: 30
		}
	  }
	});
});

</script>