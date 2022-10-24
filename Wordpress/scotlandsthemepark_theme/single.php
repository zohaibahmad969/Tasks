<?php get_header(); ?>
<div class="single-default">
<?php rdsn_banner(); ?>

<div class="row-mid">
<div class="container">
	<!--<h1><?php //rdsn_custom_title(); ?></h1>-->
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?><?php the_content(); ?><?php endwhile; endif; ?>
	<?php //ticket_link(); ?>
    <a href="javascript:history.back();" class="btn-solid btn-back link-01 trans-0-3">&lt; back</a>
</div>
</div>

</div>
<?php get_footer(); ?>