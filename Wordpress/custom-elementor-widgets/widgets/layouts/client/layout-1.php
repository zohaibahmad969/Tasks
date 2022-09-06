<?php 
while ( $all_posts->have_posts() ) :

    $all_posts->the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('wpkd-post'); ?> data-layout="1">
         
            <div class="post-grid-inner">
            	
            	<?php $this->render_thumbnail(); ?>

                <div class="kd-post-grid-text-wrap">
	                <?php $this->render_excerpt(); ?>
					<?php $this->render_person_rating(); ?>
               		<?php $this->render_title(); ?>
					<?php $this->render_person_position(); ?>
	                <?php $this->render_meta(); ?>
	                <?php $this->render_readmore(); ?>
                </div>

            </div><!-- .blog-inner -->
           
        </article>

        <?php

endwhile; 

wp_reset_postdata();