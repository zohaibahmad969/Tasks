<?php
/*
CALENDAR / OPENING TIMES
ALSO SEE TEMPLATE AJAX CALENDAR
*/


function rdsn_calendar() {  

date_default_timezone_set("Europe/London");
$this_day = date('j'); 					// this day - single digit
$month = date('n'); 					// this month - single digit
$month_full = date('m'); 				// this month - double digit
$month_word = date('F'); 				// this month - text
$year = date('Y'); 						// this year - full year
$today = date('Ymd');

echo '
<script>
jQuery(window).on("load",function(){
	jQuery("#current-month").val('.$month.');
	jQuery("#rdsn-ajax-calendar").load("'.get_bloginfo('stylesheet_directory').'/templates/ajax-calendar.php", {monthValue : '.$month.'});
})
function GetMonthName(monthNumber) {
      var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      return months[monthNumber - 1];
}
jQuery(document).ready(function(){
    jQuery(".title-month .btn-next").on( "click", function() {
		var month_value = jQuery("#current-month").val();
		month_value = parseInt(month_value) + 1;
        if (month_value > '.$month.') { jQuery(".title-month .btn-prev").show() }
		if (month_value == 12) { jQuery(".title-month .btn-next").hide() }
		jQuery("#current-month").val(month_value);
		jQuery(".title-month .title").html(GetMonthName(month_value));
		jQuery("#rdsn-ajax-calendar").load("'.get_bloginfo('stylesheet_directory').'/templates/ajax-calendar.php", {monthValue : month_value});
    });
	jQuery(".title-month .btn-prev").on( "click touchstart", function() {
		var month_value = jQuery("#current-month").val();
		month_value = parseInt(month_value) - 1;
        if (month_value == '.$month.') { jQuery(".title-month .btn-prev").hide() }
		if (month_value < 12) { jQuery(".title-month .btn-next").show() }
		jQuery("#current-month").val(month_value);
		jQuery(".title-month .title").html(GetMonthName(month_value));
		jQuery("#rdsn-ajax-calendar").load("'.get_bloginfo('stylesheet_directory').'/templates/ajax-calendar.php", {monthValue : month_value});
    });
});
</script>
';

    
//
$post_month = sb_rolling_post_month($month);    
    
//
$rep_dates = get_field('rpt_ot_date',$post_month);
$curr_date = $rep_dates[$this_day - 1];
$park_open_val = $curr_date['rpt_ot_times']['value'];
$park_open_label = $curr_date['rpt_ot_times']['label'];
$park_ot_custom = $curr_date['rpt_ot_custom'];  // 10:30am - 2pm & 2:30pm - 6pm
if($park_ot_custom) { $park_ot_times = $park_ot_custom; } else { $park_ot_times = $park_open_label; }
if ($park_open_val != 0 || $park_ot_custom) {
echo '<div class="park-open">';	
	echo '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/img-thumbs-up-02.png" alt="Open today!" class="thumbs-up" />';
	echo '<div class="btn-solid no-hover">Our outdoor rides are open today, from '.$park_ot_times.'</div>';
echo '</div>';
}
//
echo '<div class="calendar-message"><div style="max-width: 700px; padding:0 30px !important; 
margin:0 auto">';
if (have_posts()): while (have_posts()) : the_post(); the_content(); endwhile; endif; 
echo '</div></div>';
//
echo '<div class="rdsn-calendar-wrapper"><div class="rdsn-calendar"><input type="hidden" id="current-month" value="'.$month.'" />';
echo '<div class="title-month"><div class="btn-prev-wrapper"><div class="btn-prev"></div></div><div class="title">'.$month_word.'</div><div class="btn-next-wrapper"><div class="btn-next"></div></div></div>';
echo '<div class="title-days">';
	echo '<div class="cell"><span class="full">Monday</span><span class="mid">Mon</span><span class="small">M</span></div>';
	echo '<div class="cell"><span class="full">Tuesday</span><span class="mid">Tue</span><span class="small">T</span></div>';
	echo '<div class="cell"><span class="full">Wednesday</span><span class="mid">Wed</span><span class="small">W</span></div>';
	echo '<div class="cell"><span class="full">Thursday</span><span class="mid">Thu</span><span class="small">T</span></div>';
	echo '<div class="cell"><span class="full">Friday</span><span class="mid">Fri</span><span class="small">F</span></div>';
	echo '<div class="cell"><span class="full">Saturday</span><span class="mid">Sat</span><span class="small">S</span></div>';
	echo '<div class="cell"><span class="full">Sunday</span><span class="mid">Sun</span><span class="small">S</span></div>';
echo '</div>';

echo '<div id="rdsn-ajax-wrapper">';		// ajax wrapper
	echo '<div id="rdsn-ajax-calendar"></div>';		// ajax content
	echo '<div id="rdsn-ajax-day" class="trans-0-3"></div>';	// ajax content
echo '</div>';								// end wrapper

echo '</div></div>';
}



// for opening times colour coding
function sb_opclass($str = '') {
    return 'op-' .preg_replace("/[^a-z0-9\-]+/", "", strtolower($str) );
}

// associate month number with custom post type month - ROLLING 12 MONTH CALENDAR
function sb_rolling_post_month($calendar_month_number = 0) {
    $post_month = 0;
    switch ($calendar_month_number):  
			case 1: $post_month = 102954;  break;
			case 2: $post_month = 102966;  break;
			case 3: $post_month = 105174;  break;
			case 4: $post_month = 105176;  break;
			case 5: $post_month = 105179;  break;
			case 6: $post_month = 105180;  break;
			case 7: $post_month = 105181;  break;
			case 8: $post_month = 105182;  break;
			case 9: $post_month = 105183;  break;
			case 10: $post_month = 105184;  break;
			case 11: $post_month = 105185;  break;
			case 12: $post_month = 105186;  break;
	endswitch;
    return $post_month;
}


add_action('in_admin_header', 'soulbat_14179_admin_help');

function soulbat_14179_admin_help() {
    
    if ( !$screen = get_current_screen() ): return; endif;
    $post_type = $screen->post_type;
    
    switch ($post_type):
    
        case 'rdsn_opening_time';
        $content = 'Opening Time Months should not be deleted. Change Year as Required. For Feb alter days length in leap year<br />
        For Colour Coding - See "Site Settings Calendar Colours". To add new colours, click one of the Dates below and copy the Colour Code';
    
            echo '
            <style>
                .admin-helper-panel {
                    padding: 15px;background: #FFF; color: #2F7814;
                }
                p.search-box, div.tablenav.top, div.tablenav.bottom,
                .page-title-action,
                .submitdelete { display: none !important }
 
        .op-review { display:inline-block; min-width: 120px; margin: 2px 5px 5px 0; 
        padding: 2px 4px; border:1px solid #555; border-radius:4px;
        cursor:pointer;
         }
        .color-class-input { margin: 10px 0; }
        #calColourClass { width: 220px; margin-right: 10px}
      
        .col-key-container { width: 100%; display:flex; align-items: center; justify-content: center }
        .col-key-item { display: inline-flex; margin:10px; }
        .col-key-box { display: inline-block; width: 20px; height: 20px; margin-right:10px; }
        
            </style>
            
               <script>
        function showSomeClass(c) {   
            document.getElementById("calColourClass").value = c;
        }
        </script>
            
            ';

                echo '<div class="admin-helper-panel">';
                echo $content;   
                echo '<div class="color-class-input"><input type="text" id="calColourClass" /> Colour Class Picker</div>';
                echo '</div>';
    
    
            sb_calendar_key();
    
    
        break;
    
    endswitch;
    


}  

/*
render calendar key and CSS styles
for both admin and front end
*/
function sb_calendar_key() {
    
    if(!have_rows('calendar_colour_classes', 'option')): return; endif;
    $status = get_field('front_end_cal_colours_status', 'option');
    
    if(!is_admin() && $status != 'ON'): return; endif;
    
        $key_html = '<div class="col-key-container">';
    
        $timeIN = ['op-','30am','30pm'];
        $timeOUT = ['','.30am','.30pm'];
    
        echo '
        <!-- CALKEY -->
        <style>';
        while( have_rows('calendar_colour_classes', 'option') ) : the_row();

            $sub_value = get_sub_field('sub_field');
            $class = new stdClass;
            $class->status          = get_sub_field('cal_class_status');
            $class->name            = get_sub_field('cal_class_name');
            $class->background      = get_sub_field('cal_class_background');
            $class->foreground      = get_sub_field('cal_class_foreground');
    
            /* sort times */
    
            if($class->status == 'ON'):
                
                if($class->name == 'op-closed'):
                    $cki_border = ''; // 
                    $human_label = 'Rides Closed';
                else:
                    $cki_border = '';
                    $human_label = 'Rides Open '. str_replace($timeIN,$timeOUT,$class->name);  
                endif;
                
                $key_html .= '<div class="col-key-item"><span class="col-key-box '.$class->name.'" '.$class->background.'" '.$cki_border.'></span>'.$human_label.'</div>';
                echo '.' . $class->name . ' { background-color:' . $class->background . ' !important; color: ' . $class->foreground . ' !important;}'; 
                echo '.' . $class->name . ':hover { background-color:' . $class->foreground . ' !important; color: ' . $class->background . ' !important;}'; 
            endif;
     
        endwhile;
        echo '</style>
        ';
    
        $key_html .= '</div>';
        echo $key_html;
}



///// ADMIN COLUMNS - FOR OPENING TIMES

 function add_rdsn_opening_time_columns ( $columns ) {
   $cols = array_merge ( $columns, array ( 
     'optimes'   => __ ( 'Opening Times' )
   ) );
    unset($cols['date']);
     return $cols;
 }
 add_filter ( 'manage_rdsn_opening_time_posts_columns', 'add_rdsn_opening_time_columns' );




function rdsn_opening_time_custom_column ( $column, $post_id ) {
   switch ( $column ) {
           
     case 'optimes':
        $ops = get_field('rpt_ot_date',$post_id);
        if($ops):
            echo '<div>';
            foreach($ops as $k => $o):
           
               if(isset($o['rpt_ot_custom'])):
                    $times = $o['rpt_ot_custom'];
               else:
                    $times = $o['rpt_ot_times']['label'];
               endif;
               if(strlen($times)<1): $times = 'Closed'; endif;
           
               $d = str_pad($k+1, 2, '0', STR_PAD_LEFT);
               $class = sb_opclass($times);
               echo '<div 
               class="op-review '.$class.'" 
               data-css="'.$class.'" 
               onclick = "showSomeClass(\''.$class.'\')"  
               >
               <b>' .$d. '</b> '  .$times     . '</div>';
            endforeach; 
            echo '</div>';
        endif;
        break;
            
   }
 }
add_action ( 'manage_rdsn_opening_time_posts_custom_column', 'rdsn_opening_time_custom_column', 10, 2 );

function soulbat_81939_post_types_admin_order( $wp_query ) {
  if (is_admin()):
    // Get the post type from the query
    $post_type = $wp_query->query['post_type'];
    if ( $post_type == 'rdsn_opening_time') {
      $wp_query->set('orderby', 'date');
      $wp_query->set('order', 'ASC');
    }
  endif;
}
add_filter('pre_get_posts', 'soulbat_81939_post_types_admin_order');





// ********************************************************************** CALENDAR	
/*function rdsn_calendar() {  

date_default_timezone_set("Europe/London");
$this_day = date('j'); 					// this day - single digit
$month = date('n'); 					// this month - single digit
$month_full = date('m'); 				// this month - double digit
$month_word = date('F'); 				// this month - text
$year = date('Y'); 						// this year - full year
$today = date('Ymd');
//
$allow_wrap = get_field('ot_wrap','option');
//
$ot_yearlist = get_posts(array('numberposts' => -1, 'post_type' => 'rdsn_opening_time'));
foreach($ot_yearlist as $month_year):
	$ot_month_year[] = get_field('ot_year',$month_year->ID);	
endforeach;
//$ot_month_array = implode(",", $ot_month_year);
$ot_month_array = json_encode($ot_month_year);

echo '
<script>
jQuery(window).on("load",function(){
	jQuery("#current-month").val('.$month.');
	jQuery("#current-year").val('.$year.');
	jQuery("#rdsn-ajax-calendar").load("'.get_bloginfo('stylesheet_directory').'/templates/ajax-calendar.php", {monthValue : '.$month.'});
})
function GetMonthName(monthNumber) {
      var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      return months[monthNumber - 1];
}
</script>
';
if ($allow_wrap == 'no') {
echo'
<script>
jQuery(document).ready(function(){
    var month_value = jQuery("#current-month").val();
	if (month_value == 12) { jQuery(".title-month .btn-next").hide() }
	jQuery(".title-month .btn-next").on( "click", function() {
		month_value = parseInt(month_value) + 1;
		if (month_value > '.$month.') { jQuery(".title-month .btn-prev").show() }
		jQuery("#current-month").val(month_value);
		jQuery(".title-month .title").html(GetMonthName(month_value));
		jQuery("#rdsn-ajax-calendar").load("'.get_bloginfo('stylesheet_directory').'/templates/ajax-calendar.php", {monthValue : month_value});
	});
	jQuery(".title-month .btn-prev").on( "click touchstart", function() {
		var month_value = jQuery("#current-month").val();
		month_value = parseInt(month_value) - 1;
        if (month_value == '.$month.') { jQuery(".title-month .btn-prev").hide() }
		if (month_value < 12) { jQuery(".title-month .btn-next").show() }
		jQuery("#current-month").val(month_value);
		jQuery(".title-month .title").html(GetMonthName(month_value));
		jQuery("#rdsn-ajax-calendar").load("'.get_bloginfo('stylesheet_directory').'/templates/ajax-calendar.php", {monthValue : month_value});
    });
});
</script>
';
} else {
echo'
<script>
jQuery(document).ready(function(){
	var this_month = jQuery("#current-month").val();
	//console.log(this_month);
    jQuery(".title-month .btn-next").on( "click", function() {
		var year_array = '.$ot_month_array.';
		var month_value = jQuery("#current-month").val();
			//console.log(month_value);
		var year_value = jQuery("#current-year").val();	
        if (month_value == 12) { month_value = parseInt(month_value) - 11; year_value = parseInt(year_value) + 1; } else { month_value = parseInt(month_value) + 1; }
		if (month_value == 1) { jQuery(".title-month .btn-next").hide() } // TEMP
		if (month_value != this_month) { jQuery(".title-month .btn-prev").show() }
		jQuery("#current-month").val(month_value);
			//console.log(month_value);
			//var month_value_for_array = parseInt(month_value) - 1;
			//console.log(month_value_for_array);
			//var year_value_from_array = jQuery(year_array).get(month_value_for_array);
			//console.log(year_value_from_array);
			// temp shelved due to time as would need to update "year_value" throughout based on "year_array", using fixed var instead for now.
		jQuery("#current-year").val(year_value);
		jQuery(".title-month .title").html(GetMonthName(month_value));
		jQuery("#rdsn-ajax-calendar").load("'.get_bloginfo('stylesheet_directory').'/templates/ajax-calendar.php", {monthValue : month_value, yearValue : year_value});
    });
	jQuery(".title-month .btn-prev").on( "click touchstart", function() {
		var year_array = '.$ot_month_array.';
		var month_value = jQuery("#current-month").val();
		var year_value = jQuery("#current-year").val();
		if (month_value == 1) { month_value = parseInt(month_value) + 11; year_value = parseInt(year_value) - 1; } else { month_value = parseInt(month_value) - 1; }
        if (month_value == this_month) { jQuery(".title-month .btn-prev").hide() }
		if (month_value == 12) { jQuery(".title-month .btn-next").show() }  // TEMP
		jQuery("#current-month").val(month_value);
			//var month_value_for_array = parseInt(month_value) - 1;
			//console.log(month_value_for_array);
			//var year_value_from_array = jQuery(year_array).get(month_value_for_array);
			//console.log(year_value_from_array);
		jQuery("#current-year").val(year_value);
		jQuery(".title-month .title").html(GetMonthName(month_value));
		jQuery("#rdsn-ajax-calendar").load("'.get_bloginfo('stylesheet_directory').'/templates/ajax-calendar.php", {monthValue : month_value, yearValue : year_value});
    });
});
</script>
';	
}
//
switch ($month) {  // associate month number with custom post type month
    case 1: $post_month = 458;  break;
    case 2: $post_month = 457;  break;
	case 3: $post_month = 456;  break;
	case 4: $post_month = 455;  break;
	case 5: $post_month = 454;  break;
	case 6: $post_month = 453;  break;
	case 7: $post_month = 452;  break;
	case 8: $post_month = 451;  break;
	case 9: $post_month = 450;  break;
	case 10: $post_month = 449;  break;
	case 11: $post_month = 448;  break;
	case 12: $post_month = 443;  break;
}
//
$rep_dates = get_field('rpt_ot_date',$post_month);
$curr_date = $rep_dates[$this_day - 1];
$park_open_val = $curr_date['rpt_ot_times']['value'];
$park_open_label = $curr_date['rpt_ot_times']['label'];
if ($park_open_val != 0) {
echo '<div class="park-open">';	
	echo '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/img-thumbs-up-02.png" alt="Open today!" class="thumbs-up" />';
	echo '<div class="btn-solid no-hover">Our theme park is open today, from '.$park_open_label.'</div>';
echo '</div>';
}
//
echo '<div class="rdsn-calendar-wrapper"><div class="rdsn-calendar"><input type="hidden" id="current-month" value="'.$month.'" /><input type="hidden" id="current-year" value="'.$year.'" />';
echo '<div class="title-month"><div class="btn-prev-wrapper"><div class="btn-prev"></div></div><div class="title">'.$month_word.'</div><div class="btn-next-wrapper"><div class="btn-next"></div></div></div>';
echo '<div class="title-days">';
	echo '<div class="cell"><span class="full">Monday</span><span class="mid">Mon</span><span class="small">M</span></div>';
	echo '<div class="cell"><span class="full">Tuesday</span><span class="mid">Tue</span><span class="small">T</span></div>';
	echo '<div class="cell"><span class="full">Wednesday</span><span class="mid">Wed</span><span class="small">W</span></div>';
	echo '<div class="cell"><span class="full">Thursday</span><span class="mid">Thu</span><span class="small">T</span></div>';
	echo '<div class="cell"><span class="full">Friday</span><span class="mid">Fri</span><span class="small">F</span></div>';
	echo '<div class="cell"><span class="full">Saturday</span><span class="mid">Sat</span><span class="small">S</span></div>';
	echo '<div class="cell"><span class="full">Sunday</span><span class="mid">Sun</span><span class="small">S</span></div>';
echo '</div>';

echo '<div id="rdsn-ajax-wrapper">';		// ajax wrapper
	echo '<div id="rdsn-ajax-calendar"></div>';		// ajax content
	echo '<div id="rdsn-ajax-day" class="trans-0-3"></div>';	// ajax content
echo '</div>';								// end wrapper

echo '</div></div>';
}*/

