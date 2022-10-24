<?php get_header(); ?>
<div class="page-search">

<div class="row-mid">
<div class="container group">

    <?php
	/*if( is_search() )  :
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		query_posts("s=$s&paged=$paged");
	endif;*/
	?>
    
    <?php if(have_posts()): ?>
    	<h1>Search Results</h1>
    	<p style="padding-bottom:20px;">
        	<strong>
				<?php $myCount = $wp_query->found_posts; if($myCount == 1) { $item_txt = 'item';  } else { $item_txt = 'items'; }; echo $myCount.' '.$item_txt.' with a reference to "'. get_search_query() .'"'; wp_reset_query();?>
            </strong>
        </p>
		
    	<div class="list-01-wrapper">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="list-01">
    				<h4><a href="<?php the_permalink(); ?>"><?php rdsn_custom_title(); ?></a></h4>
    				<?php search_page_excerpt(); ?>
    			</div>
    		<?php endwhile; ?>
    	</div>
    	<div class="posts-nav-link"><?php posts_nav_link(); ?></div>
    
	<?php else: ?>
		<h1>Nothing Found</h1>
		<p><?php echo 'Sorry, nothing matched your search for "'. get_search_query()  .'". Please try again.'; ?></p>
	<?php endif; ?> 

</div>
</div>

</div>
<?php get_footer(); ?>