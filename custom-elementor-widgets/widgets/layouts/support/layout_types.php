<?php 
foreach ( $supportterms as $term ) :?>

        <div <?php post_class('wpkd-post'); ?>>
         
            <div class="post-grid-inner">
                
                <?php $this->render_thumbnail($term); ?>

                <div class="post-grid-text-wrap">
                    <?php $this->render_title($term); ?>
					<?php $this->render_count($term); ?>
                </div>

            </div><!-- .blog-inner -->
           
        </div>

        <?php

endforeach;