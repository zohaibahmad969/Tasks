<div class="page-home">
	<?php rdsn_banner(); ?>
	<div class="row-mid">
        
		<?php
		date_default_timezone_set("Europe/London");
		$this_day = date('j'); // this day - single digit
		$month = date('n');  // this month - single digit
		switch ($month) {  // associate month number with custom post type month
            case 1: $post_month = 458;  break;
            case 2: $post_month = 457;  break;
            case 3: $post_month = 456;  break;
            case 4: $post_month = 455;  break;
            case 5: $post_month = 452;  break;
            case 6: $post_month = 453;  break;
            case 7: $post_month = 452;  break;
            case 8: $post_month = 451;  break;
            case 9: $post_month = 450;  break;
            case 10: $post_month = 449;  break;
            case 11: $post_month = 448;  break;
            case 12: $post_month = 443;  break;
        }
        
		$rep_dates = get_field('rpt_ot_date',$post_month);
        if($rep_dates):
		$curr_date = $rep_dates[$this_day - 1];
		//
            $park_open_val = $curr_date['rpt_ot_times']['value'];
            $park_open_label = $curr_date['rpt_ot_times']['label'];
            $park_ot_custom = $curr_date['rpt_ot_custom'];  // eg: 10:30am - 2pm & 2:30pm - 6pm
            if($park_ot_custom) { $park_ot_times = $park_ot_custom; } else { $park_ot_times = $park_open_label; }
            if ($park_open_val != 0 || $park_ot_custom):
            echo '<div class="park-open">';	
                //echo '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/img-thumbs-up-02.png" alt="Open today!" class="thumbs-up" />';
                echo '<div class="btn-solid no-hover">Our outdoor rides are open today, from '.$park_ot_times.'</div>';
            echo '</div>';
            endif;
        endif;
		?>
        
		<?php if (have_posts()): while (have_posts()) : the_post(); the_content(); endwhile; endif; ?>
		<?php rdsn_home_carousel(); ?>
	</div>
</div>



