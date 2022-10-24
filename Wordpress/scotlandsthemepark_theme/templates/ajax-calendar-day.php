<?php


	require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');
	//if( $_REQUEST["dateValue"] ) { $calday->date_unformatted = $_REQUEST['dateValue']; }
    $calday = new stdClass;
	$calday->this_day          = $_REQUEST['dayValue'];
	$calday->this_month        = $_REQUEST['monthValue'];
	$calday->date_unformatted  = $_REQUEST['dateValue'];
	$calday->date_formatted    = date('l, jS F',strtotime($calday->date_unformatted));	
	$calday->date_short        = date('jS F',strtotime($calday->date_unformatted));
    // 
    $post_month = sb_rolling_post_month($calday->this_month); 
	$calday->rep_rows             = get_field('rpt_ot_date',$post_month);
	$calday->day_row              = $calday->rep_rows[$calday->this_day - 1];
	$calday->park_ot_val          = $calday->day_row['rpt_ot_times']['value'];
	$park_ot_label = $calday->day_row['rpt_ot_times']['label'];
	$park_ot_custom = $calday->day_row['rpt_ot_custom'];
	$day_content = $calday->day_row['rpt_ot_notes'];
	$day_events = $calday->day_row['rpt_ot_events'];
	$ticket_link = get_field('main_ticket_url','option');	
	$complex_closed = $calday->day_row['rpt_ot_complex_closed'];
	$complex_closed_message = get_field('complex_closed_message','option');
        
    
?>

<div id="rdsn-ajax-modal" class="trans-0-1">
	<div id="btn-close" class="trans-0-25">Close</div>
    <div class="title-date"><?php echo $calday->date_formatted; ?></div>
    <div class="container"><div class="content-wrapper">
    <?php
//    	

        
if ($complex_closed != 'yes'):
        
        // top message
		if($park_ot_custom):
			echo '<div class="content-ot">Our outdoor rides are open on '.$calday->date_short.', <br />from '.$park_ot_custom.'.</div>';
		elseif ( $calday->park_ot_val != 0):
			echo '<div class="content-ot">Our outdoor rides are open on '.$calday->date_short.', <br />from '.$park_ot_label.'.</div>';
		else:
			echo '<div class="content-ot">Our outdoor rides are closed today but the following attractions and events are open.</div>';	
		endif;

		if ($calday->park_ot_val != 0 || $park_ot_custom): 
                if ($ticket_link):
                        echo '<a href="'.$ticket_link.'" target="_blank" class="btn-solid ticket-link trans-0-2">Buy tickets</a>'; 
                endif;
        endif;
        
		if ($day_content): echo '<div class="content-extra">'.$day_content.'</div>'; endif;		
        
        
		//
		if ($day_events):
            echo '<h3 class="events-title">Special Events</h3>';
            echo '<div id="e-grid" class="events-modal grid-wrapper">';
            foreach($day_events as $post) : setup_postdata($post);
                $title = get_the_title($post->ID);
                $link = get_the_permalink($post->ID);
                $image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
                if ($image_src) { $image = $image_src[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
                $placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
                $show_title = get_field('rdsn_list_show_title',$post->ID);
                $show_overlay = get_field('rdsn_list_show_overlay',$post->ID);
                echo '<div class="grid-item animated anim-up">';
                    echo '<a href="'.$link.'">';
                    echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
                    if ($show_title != 'no') { echo '<div class="title-wrapper"><h3>'.$title.'</h3></div>'; }
                    if ($show_overlay != 'no') { echo '<div class="overlay"></div>'; }
                    echo '</a>';
                echo '</div>';
                endforeach;
            wp_reset_postdata();
            echo '</div>';
		endif;
		

		$args = array( 'post_type' => 'page', 'posts_per_page' => -1,'post_parent' => 111, 'orderby' => 'menu_order' );
		$wp_query = NULL;
		$wp_query = new WP_Query();
		$wp_query->query($args);
        
		if ($wp_query->have_posts()):
		echo '<div class="list-wrapper"><h2>Attractions</h2>';
        
		while ($wp_query->have_posts()):$wp_query->the_post();
        
        
            $block = new stdClass;
            $block->id          = get_the_ID();
            $block->title       = get_the_title();
            $block->link        = get_the_permalink();
            $block->mon         = get_field('ot_monday');
            $block->tue         = get_field('ot_tuesday');
            $block->wed         = get_field('ot_wednesday');
            $block->thu         = get_field('ot_thursday');
            $block->fri         = get_field('ot_friday');
            $block->sat         = get_field('ot_saturday');
            $block->sun         = get_field('ot_sunday');
            $block->notes       = get_field('ot_notes');
               
//            echo '<div>' .  $block->title . '</div>'; DEBUGGING
//            echo '<div>' .  $calday->park_ot_val . '</div>';
//            echo '<div>---</div>';

                echo '<div class="list-item animated anim-up">';
                    
                    echo '<div class="row top"><div class="title">'.$block->title.'</div></div>';
                    echo '<div class="content"><div class="inner">';
                        
                        $aa = '<div class="row group"><div class="left border-box">';
                        $bb = '</div><div class="right border-box">';
                        $cc = '</div></div>';
                    
                        echo $aa . 'Monday' .  $bb . $block->mon . $cc;
                        echo $aa . 'Tuesday' .  $bb . $block->tue . $cc;
                        echo $aa . 'Wednesday' .  $bb . $block->wed . $cc;
                        echo $aa . 'Thursday' .  $bb . $block->thu . $cc;
                        echo $aa . 'Friday' .  $bb . $block->fri . $cc;
                        echo $aa . 'Saturday' .  $bb . $block->sat . $cc;
                        echo $aa . 'Sunday' .  $bb . $block->sun . $cc;
                    
                        if ($block->notes): echo '<div class="notes">'.$block->notes.'</div>'; endif;
                    echo '</div></div>';
                echo '</div>';
        
        
		endwhile;
        
        
		$wp_query = NULL;
		wp_reset_postdata();
		echo '</div>';
		endif;
	 
		rdsn_food_drink_ot();
	 
        
		else: // closed
			echo '<div class="content-ot">'.$complex_closed_message.'</div>';
		endif;
		?>
    </div></div>
</div>



<script>
jQuery(document).ready(function(){
    var cal_height = jQuery('#rdsn-ajax-calendar').height();
	jQuery('#rdsn-ajax-modal').css({'min-height': cal_height + 'px'});
	//
	jQuery("#rdsn-ajax-modal").addClass('active');
	jQuery("#rdsn-ajax-modal #btn-close").on( "click touchstart", function() {
		jQuery("#rdsn-ajax-modal").removeClass('active');
		jQuery("#rdsn-ajax-day").removeClass('active');	
		jQuery("#rdsn-ajax-modal .title").html('&nbsp;');
    });
});
</script>