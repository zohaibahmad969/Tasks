<?php get_header(); ?>
<div class="single-ride">
<?php rdsn_banner(); ?>

<div class="row-mid">
<div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?><?php the_content(); ?><?php endwhile; endif; ?>
	<?php //$user_id = get_current_user_id(); if($user_id == '1'):?>
	<?php
		$fun_points = get_field('fun_points');
		//
		$ride_terms = get_the_terms(get_the_ID(),'tax_ride_type');
		$first_ride_term = $ride_terms[0];
		$ride_type_name = $first_ride_term->name;
		$ride_type = strtok($ride_type_name, " ");
		//
		$height_terms = get_the_terms(get_the_ID(),'tax_ride_height');
		$first_height_term = $height_terms[0];
		$height_type = $first_height_term->name;
	?>
	<div id="ride-info" class="grid-wrapper">
		<div class="grid-item animated anim-up">
        	<div class="title">Ride type</div>
            <div class="info-circle"><?php echo $ride_type; ?></div>
        </div>
        <div class="grid-item animated anim-up">
        	<div class="title">Minimum height</div>
            <div class="info-circle"><?php echo $height_type; ?></div>
        </div>
        <div class="grid-item animated anim-up">
        	<div class="title">Fun points</div>
            <div class="info-circle"><?php echo $fun_points; ?></div>
        </div>
	</div>
	<?php //endif;?>
    <a href="javascript:history.back();" class="btn-solid back-link link-01 trans-0-3">&lt; back</a>
</div>
</div>

</div>
<?php get_footer(); ?>


