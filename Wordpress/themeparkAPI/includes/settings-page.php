<div class="wrap">
	
    <h1><?php _e('Scotlandsthemepark Settings', 'scotlandsthemepark'); ?></h1>
    
    <div id="alert"></div>
    
    <form method="post" action="options.php">
                
    <?php settings_fields( 'scotlandsthemepark-settings-group' );?>

    <div class="row col4">

            <!--COLUMN 1 General style -->
            
            <div class="column left">
                
                <div class="block S">
                   <label for=""><b><?php _e('Device ID', 'scotlandsthemepark' ); ?></b></label><br/>
                   <input type="text" name="device_id" id="device_id" required value="<?php //echo $options['device_id'];?>" />		
                </div>   
                 <div class="block S">
                   <label for=""><b><?php _e('Device Tocken', 'scotlandsthemepark' ); ?></b></label><br/>
                   <input type="text" name="device_id" id="device_tocken" required value="<?php //echo $options['device_tocken'];?>" />		
                </div>  

                 

            </div><!--column-->	

    </div><!--row-->

    <div class="block">
        <input type="submit" class="button-primary" value="<?php _e('Save', 'scotlandsthemepark'); ?>" />
    </div>	
                    
    </form>	
</div>

