<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');

sb_calendar_key();

if( $_REQUEST["monthValue"] ) { $month = $_REQUEST['monthValue']; } // month is passed from ajax request
date_default_timezone_set("Europe/London");
$month_full = str_pad($month, 2, '0', STR_PAD_LEFT);
$year = date('Y'); 						// this year - full year
$today = date('Ymd');

$post_month = sb_rolling_post_month($month); 

$first_day = mktime(0,0,0,$month,1,$year);  	// generate the first day of the month
$title = date('F', $first_day);               	// the month name 
$day_of_week = date('D', $first_day);         	// day of week for 1st day of month
switch($day_of_week) {                        	// blank days before months first day
	case "Mon": $blankdays = 0; break; 
	case "Tue": $blankdays = 1; break; 
	case "Wed": $blankdays = 2; break; 
	case "Thu": $blankdays = 3; break; 
	case "Fri": $blankdays = 4; break; 
	case "Sat": $blankdays = 5; break; 
	case "Sun": $blankdays = 6; break;
}

//$days_in_month = cal_days_in_month(0, $month, $year); // days in the month
$days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));

$day_count = 1;
$blank_cnt =  $blankdays;
while ( $blank_cnt > 0 ) {                   // blank day table cells
	echo '<div class="cell"></div>'; 
	$blank_cnt--; 
	$day_count++;
}

$day_num = 1;                                // day number
$cnt = $blankdays;                           // skip blank days in first week

while ( $day_num <= $days_in_month ) {       // count days until done
	if ($cnt==7) {$cnt = 0;};
    
	while ($cnt < 7) {
		$rep_rows = get_field('rpt_ot_date',$post_month);
        
		$curr_row = $rep_rows[$day_num - 1];
		$open_time = $curr_row['rpt_ot_times']['value'];
        $op_class = (isset($curr_row['rpt_ot_custom']))? sb_opclass($curr_row['rpt_ot_custom']) : '';  // for color coding      
		if ($open_time == 0) { $open_class = ' closed'; } else { $open_class = ''; } // $open_class // deprecated
		//
		$day_num_full = str_pad($day_num, 2, '0', STR_PAD_LEFT);
		$data_date = $year.$month_full.$day_num_full;
		if ($data_date == $today) { $today_class = ' today'; } else { $today_class = ''; }
        $dayclass = ' calday' . $data_date;
		echo '<div class="cell content'.$today_class.' '.$op_class.' trans-0-3"  data-day="'.$day_num.'" data-month="'.$month.'" data-date="'.$data_date.'">'.$day_num.'</div>';
		$day_num++;
		$day_num_full++; 
		$day_count++;
		$cnt++;
		if ($day_num > $days_in_month) {break;}
  	}
}
while ( $cnt > 1 && $cnt <=6 ) {            // continue with $cnt for end of month blank days
	echo '<div class="cell"></div>';
	$cnt++;
}
?>
<script>
jQuery(document).ready(function(){
    jQuery(".rdsn-calendar .cell.content").on( "click touchstart", function() {
		var cal_height = jQuery('#rdsn-ajax-calendar').height();
		jQuery('#rdsn-ajax-day').css({'min-height': cal_height + 'px'});
		//alert (cal_height);
		//
		var day_value = jQuery(this).attr("data-day");
		var month_value = jQuery(this).attr("data-month");
		var date_value = jQuery(this).attr("data-date");
		jQuery("#rdsn-ajax-day").load("<?php echo get_bloginfo('stylesheet_directory'); ?>/templates/ajax-calendar-day.php", { dayValue : day_value, monthValue : month_value, dateValue : date_value });
		jQuery("#rdsn-ajax-day").addClass('active');
    });
});
</script>