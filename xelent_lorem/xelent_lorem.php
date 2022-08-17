<?php
/**
 * Plugin Name:       Xelent Lorem
 * Plugin URI:        https://xelent.com
 * Description:       Wordpress Tasks
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Zohaib Ahmad
 * Author URI:        https://zohaibahmad.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       xelent
 * Domain Path:       /languages
**/

//* Don't access this file directly
defined( 'ABSPATH' ) or die();

/*------------------------------------*\
	Create Custom Post Types
\*------------------------------------*/
add_action('init', 'tableData_post_type');
function tableData_post_type() {
    register_post_type('tableData', array(
        'labels' => array(
            'name' => __('Table Data', 'xelent'),
            'singular_name' => __('Table Data', 'xelent'),
            'add_new' => __('Add Table Data', 'xelent'),
            'add_new_item' => __('Add Table Data', 'xelent'),
            'edit_item' => __('Edit Table Data', 'xelent'),
            'new_item' => __('New Table Data', 'xelent'),
            'view_item' => __('View Table Data', 'xelent'),
            'view_items' => __('View Table Data', 'xelent'),
            'search_items' => __('Search Table Data', 'xelent'),
            'not_found' => __('No Table Data found.', 'xelent'),
            'not_found_in_trash' => __('No Table Data found in trash.', 'xelent'),
            'all_items' => __('All Table Data', 'xelent'),
            'archives' => __('Table Data Archives', 'xelent'),
            'insert_into_item' => __('Insert into Table Data', 'xelent'),
            'uploaded_to_this_item' => __('Uploaded to this Table Data', 'xelent'),
            'filter_items_list' => __('Filter Table Data list', 'xelent'),
            'items_list_navigation' => __('Table Data list navigation', 'xelent'),
            'items_list' => __('Table Data list', 'xelent'),
            'item_published' => __('Table Data published.', 'xelent'),
            'item_published_privately' => __('Table Data published privately.', 'xelent'),
            'item_reverted_to_draft' => __('Table Data reverted to draft.', 'xelent'),
            'item_updated' => __('Table Data updated.', 'xelent')
        ),
        'has_archive'   => true,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'supports' => array( 'title' ), 
        'can_export' => true
    ));
}


// add table data fields to custom post type
function add_post_meta_boxes() {
    add_meta_box(
        "post_metadata_tableData_post", // div id containing rendered fields
        "Table Data", // section heading displayed as text
        "post_meta_box_tableData_post", // callback function to render fields
        "tableData", // name of post type on which to render fields
        "normal", // location on the screen
        "low" // placement priority
    );
}
add_action( "admin_init", "add_post_meta_boxes" );


// callback function to render fields
function post_meta_box_tableData_post(){
    global $post;
    $custom = get_post_custom( $post->ID );

    // Displaying shortcode
    if( get_post_meta( $post->ID , "_tableDataShortcode" ) ){
        $shortcode = $custom[ "_tableDataShortcode" ][ 0 ];

        echo'<h3>Shortcode</h3>
             <pre>'.$shortcode.'</pre>
            ';
    }

    // Displaying table data fields
    $employee_name = $date_of_joining = $current_salary = $address = ""; 
    if( get_post_meta( $post->ID , "_employee_name" ) ){
        $employee_name = $custom[ "_employee_name" ][ 0 ];
        $date_of_joining = $custom[ "_date_of_joining" ][ 0 ];
        $current_salary = $custom[ "_current_salary" ][ 0 ];
        $address = $custom[ "_address" ][ 0 ];
    }
    echo'<table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label>Employee Name</label></th>
                    <td><input type="text" name="_employee_name" value="'.$employee_name.'" placeholder="Employee name"></td>
                </tr>
                <tr>
                    <th scope="row"><label>Date of Joining</label></th>
                    <td><input type="date" name="_date_of_joining" value="'.$date_of_joining.'" placeholder="Date of Joining"></td>
                </tr>
                <tr>
                    <th scope="row"><label>Current Salary</label></th>
                    <td><input type="number" name="_current_salary" value="'.$current_salary.'" placeholder="Current Salary"></td>
                </tr>
                <tr>
                    <th scope="row"><label>Address</label></th>
                    <td><textarea rows="4" cols="50" name="_address">'.$address.'</textarea></td>
                </tr>
            </tbody>
        </table>
        ';
}



// save field value
function save_post_meta_boxes(){
    global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( $post ){

        // Updating Post meta data
        update_post_meta( $post->ID, "_employee_name", sanitize_text_field( $_POST[ "_employee_name" ] ) );
        update_post_meta( $post->ID, "_date_of_joining", sanitize_text_field( $_POST[ "_date_of_joining" ] ) );
        update_post_meta( $post->ID, "_current_salary", sanitize_text_field( $_POST[ "_current_salary" ] ) );
        update_post_meta( $post->ID, "_address", sanitize_text_field( $_POST[ "_address" ] ) );

    }
}
add_action( 'save_post', 'save_post_meta_boxes' );



// Create shortcode for table data
// [tabledata] or [tabledata id="1"]

add_shortcode('tabledata' , 'tabledata_shortcode_fn');

function tabledata_shortcode_fn( $atts = '' ) {

    $attr = shortcode_atts( array(
        'id' => 0,
    ), $atts );

    global $post;
    $args = array(
        'post_type' =>'tabledata',
        'post_status'=>'publish',
        'p'          => (int)$attr["id"]
    );
    $query = new WP_Query($args);

    $content = "";
    if($query->have_posts()):
        $content = '<ul>';
        while($query->have_posts()): $query->the_post();
            // display event
            $content .= '
                        <li> <b>Employee Name:</b> '.get_post_meta($post->ID, '_employee_name', true).'</li>
                        <li> <b>Date of Joining:</b> '.get_post_meta($post->ID, '_date_of_joining', true).'</li>
                        <li> <b>Current Salary:</b> '.get_post_meta($post->ID, '_current_salary', true).'</li>
                        <li> <b>Address:</b> '.get_post_meta($post->ID, '_address', true).'</li>
                '; 
        endwhile;
        $content .= '</ul>';
    else: 
        $content = '<h3>Sorry, nothing to display.</h3>';
    endif;

    return $content;

}











// Registering Settings for plugin

add_action( 'admin_init', 'xelent_register_settings' );
function xelent_register_settings() {
   
   register_setting( 'xelent_options_group', 'xelent_num_of_products' );
   register_setting( 'xelent_options_group', 'xelent_woo_category' );
   register_setting( 'xelent_options_group', 'xelent_random_or_yesterday' );

}


// Creating admin menu

add_action( 'admin_menu', 'rudr_top_lvl_menu' );
function rudr_top_lvl_menu(){
 
    add_menu_page(
        'Xelent Settings', // page <title>Title</title>
        'Xelent', // link text
        'manage_options', // user capabilities
        'xelent-lorem', // page slug
        'xelent_menu_fn', // this function prints the page content
        'dashicons-images-alt2', // icon (from Dashicons for example)
        4 // menu position
    );
}
 
function xelent_menu_fn(){
    ?>
  <div>
  <?php screen_icon(); ?>
    <h2>Get Woocomerece Prodcuts</h2>
    <form method="post" action="options.php">
      <?php settings_fields( 'xelent_options_group' ); ?>
      <table>
          <tr valign="top">
              <th scope="row"><label for="xelent_num_of_products">Num of Products</label></th>
              <td><input type="text" id="xelent_num_of_products" name="xelent_num_of_products" value="<?php echo get_option('xelent_num_of_products'); ?>" /></td>
          </tr>
          <tr valign="top">
              <th scope="row"><label for="xelent_woo_category">Category</label></th>
              <td>
                <select id="xelent_woo_category" name="xelent_woo_category">
                    <?php
                         $args = array(
                                 'taxonomy'     => 'product_cat',
                                 'orderby'      => 'name',
                                 'show_count'   => 0,
                                 'pad_counts'   => 0,
                                 'hierarchical' => 1,
                                 'title_li'     => '',
                                 'hide_empty'   => 0
                          );
                         $all_categories = get_categories( $args );
                         foreach ($all_categories as $cat) {
                            if($cat->category_parent == 0) {
                                $category_id = $cat->term_id;       
                                echo '<option>'. $cat->name .'</option>';
                            }       
                        }
                    ?>
                </select>
            </td>
          </tr>
          <tr valign="top">
              <th scope="row"><label for="xelent_random_or_yesterday">Random or yesterday sold products</label></th>
              <td><input type="text" id="xelent_random_or_yesterday" name="xelent_random_or_yesterday" value="<?php echo get_option('xelent_random_or_yesterday'); ?>" /></td>
          </tr>
      </table>
      <?php  submit_button(); ?>
    </form>
  </div>
<?php

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => (int)get_option('xelent_num_of_products'),
        'product_cat'    => get_option('xelent_woo_category')
    );

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;
        echo '<br /><a href="'.get_permalink().'">'.get_the_title().'</a>';
    endwhile;

    wp_reset_query();

}
