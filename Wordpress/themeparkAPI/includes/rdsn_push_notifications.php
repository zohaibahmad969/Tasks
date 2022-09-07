<div class="wrap">
	<?php 
	if(isset($_REQUEST['rdsn_notification'])){
		if($_REQUEST['rdsn_location_id']=='all'){
			rdsn_send_notification_admin();
		}
		else{
			rdsn_send_notification_location_base_admin();
		}
			
	}
	?>
    <h1><?php _e('Send Notification', 'scotlandsthemepark'); ?></h1>
    
    <div id="alert"></div>
    
    <form method="post" action="">
                
    <div class="row col4">

            <!--COLUMN 1 General style -->
            
            <div class="column left">
                
                <div class="block S">
                   <label for=""><b><?php _e('Notification Title', 'scotlandsthemepark' ); ?></b></label><br/>
                   <input type="text" name="rdsn_notification_title" id="rdsn_notification_title" required />		
                </div>   
                <div class="block L">
                   <label for=""><b><?php _e('Notification', 'scotlandsthemepark' ); ?></b></label><br/>
                   <textarea name="rdsn_notification" id="rdsn_notification" required></textarea>		
                </div>  
                 <div class="block S">
                   <label for=""><b><?php _e('Notification by users or location', 'scotlandsthemepark' ); ?></b></label><br/>
                   <select type="text" name="rdsn_location_id" id="rdsn_location_id">
                       <option value="all">All Locations</option>
                       <?php $args = array( 'post_type' => 'rdsn_locations','post_status' => 'publish', 'numberposts' => -1 );
							$the_query = new WP_Query( $args );
							if ( $the_query->have_posts() ) {
								while ( $the_query->have_posts() ) { $the_query->the_post(); 
								if(get_field('google_map', get_the_ID())){
								  $rdsn_location = get_field('google_map', get_the_ID());
					   ?>
					   <option value="<?php echo get_the_ID();?>"><?php echo $rdsn_location['address'];?></option>
                       <?php }}}?>
                   </select>		
                </div>  

                 

            </div><!--column-->	

    </div><!--row-->

    <div class="block" style="margin-top:20px;">
        <input type="submit" class="button-primary" value="<?php _e('Send', 'scotlandsthemepark'); ?>" />
    </div>	
                    
    </form>	
</div>

