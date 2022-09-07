<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $wpdb;
	
		$table = new Push_Notifications_List();
		$table->prepare_items();
	
		$message = '';
		if ('delete' === $table->current_action()) {
			$message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Notification deleted: %d', 'custom_table_example'), count(intval($_REQUEST['ids']))) . '</p></div>';
		}
		?>
	<div class="wrap">
	
		<div class="icon32 icon32-posts-post" id="icon-edit"><br></div>

		  <form method="post">
                <input type="hidden" name="page" value="rdsn_app_notification" />
                <?php $table->search_box('search', 'search_id'); ?>
            </form>
		<?php echo $message; ?>
	  
	<form id="items-table" method="GET">
   
            <input type="hidden" name="page" value="rdsn_app_notification" />
			<input type="hidden" name="paged" value="<?php echo esc_html($_REQUEST['paged']) ?>"/>
			<?php $table->display() ?>
	</form>
	
	</div>
	<?php

/**
 * Files List Class.
 *
 * A class that generates the list for files.
 *
 * @category Files
 * @package  Find Cheap Booking
 * @version  1.0.0
 */
class Push_Notifications_List extends WP_List_Table {

	/**
	 * Init
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @return bool
	 */
	public function __construct() {
		global $wpdb;

		parent::__construct( array(
			'singular'  => 'app_push_notification',
			'plural'    => 'app_push_notifications',
			'ajax'      => false,
		) );

		return true;
	}

	/**
	 * Prepares the items for display
	 *
	 * @todo this needs to be cached
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @return bool
	 */
	public function prepare_items() {
		global $wpdb;
 
        $table_name = $wpdb->prefix . 'themepark_push_notification';
		$columns  = $this->get_columns();
		$hidden   = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();

		$this->process_bulk_action();
		if(!isset($_REQUEST['paged'])){
			
			$_REQUEST['paged'] = 1;
		}

		$this->_column_headers = array( $columns, $hidden, $sortable );

		$orderby = ! empty( $_REQUEST['orderby'] ) ? sanitize_text_field( $_REQUEST['orderby'] ) : 'device_id';
		$order   = ( ! empty( $_REQUEST['order'] ) && 'asc' === $_REQUEST['order'] ) ? 'ASC' : 'DESC';

		$items_per_page = 20;
        $pagedtrs = intval($_REQUEST['paged']);
		$current_page = (null !== $pagedtrs) ? max(0, intval(($_REQUEST['paged'])) - 1) : 0;
        if($current_page == 0){
			
			$current_page = 1;
		}
		$sql = 'SELECT COUNT(dv.id) FROM ' . $table_name . ' AS dv';

		// check if it is a search
		if ( ! empty( $_REQUEST['s'] ) ) {
			$device_id = absint( $_REQUEST['s'] );

			$sql .= " Where `id` = {$device_id} OR `location_id` = {$device_id} OR `notification` = {$device_id} OR `status` = {$device_id}";

		} else {


			if ( ! empty( $_REQUEST['location_id'] ) ) {
				$commission_status = esc_sql( $_REQUEST['location_id'] );

				$status_filter = "`location_id` = '{$location_id}'";

				$sql .= $status_filter;
			}
			if ( ! empty( $_REQUEST['notification'] ) ) {
				$commission_status = esc_sql( $_REQUEST['notification'] );

				$status_filter = " AND `notification` = '{$notification}'";

				$sql .= $status_filter;
			}
		}

		$total_items = $wpdb->get_var( $sql );

		$this->set_pagination_args( array(
			'total_items' => (double) $total_items,
			'per_page'    => $items_per_page,
		) );

		$offset = ( $current_page - 1 ) * $items_per_page;

		$sql = 'SELECT * FROM ' . $table_name . ' AS device';

		// check if it is a search
		if ( ! empty( $_REQUEST['s'] ) ) {
			$device_id = absint( $_REQUEST['s'] );

			$sql .= " Where `id` = {$device_id} OR `location_id` = {$device_id} OR `notification` = {$device_id} OR `status` = {$device_id}";

		} 

		$sql .= " ORDER BY `{$orderby}` {$order}";

		$sql .= " LIMIT {$items_per_page}";

		$sql .= " OFFSET {$offset}";

		$data = $wpdb->get_results( $sql );

		$this->items = $data;

		return true;
	}

	/**
	 * Adds additional views
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @param mixed $views
	 * @return bool
	 */
	public function get_views() {
		$views = array(
			'all' => '<li class="all"><a href="' . admin_url( 'admin.php?page=rdsn_app_notification' ) . '">' . esc_html__( 'Show All', 'app_device' ) . '</a></li>',
		);

		return $views;
	}

	/**
	 * Generate the table navigation above or below the table
	 *
	 * @since 3.1.0
	 * @access protected
	 * @param string $which
	 */
	protected function display_tablenav( $which ) {
		if ( 'top' === $which ) {
			wp_nonce_field( 'bulk-' . $this->_args['plural'], '_wpnonce', false );
		}
		?>
		<div class="tablenav <?php echo esc_attr( $which ); ?>">

		<?php if ( $this->has_items() ) : ?>
		<div class="alignleft actions bulkactions">
			<?php $this->bulk_actions( $which ); ?>
		</div>
		<?php endif;
		$this->extra_tablenav( $which );
		$this->pagination( $which );
		?>

		<br class="clear" />
		</div>
		<?php
	}

	/**
	 * Adds filters to the table
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @param string $position whether top/bottom
	 * @return bool
	 */
	public function extra_tablenav( $position ) {
		if ( 'top' === $position ) {
		?>
			
		<?php
		}
	}

	/**
	 * Displays the months filter
	 *
	 * @todo this needs to be cached
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @return bool
	 */



	/**
	 * Defines the columns to show
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @return array $columns
	 */
	public function get_columns() {
		$columns = array(
			'cb'                      => '<input type="checkbox" />',
			'device_id'                => __( 'Device ID', 'devices' ),
			'location_id'            => __( 'Location ID', 'devices' ),
			'notification'              => __( 'Notification', 'devices' ),
			'status'              => __( 'Status', 'devices' ),
			'checkin_date_time'        => __( 'Checkin Date Time', 'devices' ),

		);

		return $columns;
	}

	/**
	 * Adds checkbox to each row
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @param object $item
	 * @return mixed
	 */
	public function column_cb( $item ) {
		
		return sprintf( '<input type="checkbox" name="ids[%d]" value="%d" />', $item->id , $item->id );
	}

	/**
	 * Defines what data to show on each column
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @param array $item
	 * @param string $column_name
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		return $item->$column_name;
	}

	/**
	 * Defines the hidden columns
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @return array $columns
	 */
	public function get_hidden_columns() {
		// get user hidden columns
		$hidden = get_hidden_columns( $this->screen );

		$new_hidden = array();

		foreach ( $hidden as $k => $v ) {
			if ( ! empty( $v ) ) {
				$new_hidden[] = $v;
			}
		}

		return array_merge( array(), $new_hidden );
	}

	/**
	 * Returns the columns that need sorting
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @return array $sort
	 */
	public function get_sortable_columns() {
		$sort = array(
        'device_id' => array( 'device_id', false ),
			'location_id' => array( 'location_id', false ),
			'notification' => array( 'notification', false ),
		);


		return $sort;
	}

	/**
	 * Display custom no items found text
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @return bool
	 */
	public function no_items() {
		_e( 'No files found.', 'devices' );

		return true;
	}

	/**
	 * Add bulk actions
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @return bool
	 */
	public function get_bulk_actions() {
		$actions = array(
			'delete' => 'Delete'
		);

		return $actions;
	}

	/**
	 * Processes bulk actions
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @return bool
	 */
	public function process_bulk_action() {
		
		global $wpdb;
 
        $table_name = $wpdb->prefix . 'themepark_push_notification';
		
        if ( empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-app_push_notifications' ) ) {
			return;
		}
		if ( empty( $_REQUEST['ids'] ) ) {
			return;
		}
		$ids = array_map( 'absint', $_REQUEST['ids'] );

		$processed = 0;
		
		if ( false === $this->current_action() ) {
			return;
		}

		$status = sanitize_text_field( $this->current_action() );


		if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM ".$table_name." WHERE id IN($ids)");
            }

		return true;
	}

	
	/**
	 * Print column headers, accounting for hidden and sortable columns.
	 * this overrides WP core simply to make column headers use REQUEST instead of GET
	 *
	 * @access public
	 * @since 2.0.0
	 * @version 2.0.0
	 * @param bool $with_id Whether to set the id attribute or not
	 * @return bool
	 */
	public function print_column_headers( $with_id = true ) {
		list( $columns, $hidden, $sortable ) = $this->get_column_info();

		$current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		$current_url = remove_query_arg( 'paged', $current_url );

		if ( isset( $_REQUEST['orderby'] ) ) {
			$current_orderby = $_REQUEST['orderby'];
		} else {
			$current_orderby = '';
		}

		if ( isset( $_REQUEST['order'] ) && 'desc' == $_REQUEST['order'] ) {
			$current_order = 'desc';
		} else {
			$current_order = 'asc';
		}

		if ( ! empty( $columns['cb'] ) ) {
			static $cb_counter = 1;

			$columns['cb'] = '<label class="screen-reader-text" for="cb-select-all-' . $cb_counter . '">' . esc_html__( 'Select All', 'cheapbooking' ) . '</label>'
				. '<input id="cb-select-all-' . $cb_counter . '" type="checkbox" />';

			$cb_counter++;
		}

		foreach ( $columns as $column_key => $column_display_name ) {
			$class = array( 'manage-column', "column-$column_key" );

			$style = '';

			if ( in_array( $column_key, $hidden ) ) {
				$style = 'display:none;';
			}

			$style = ' style="' . $style . '"';

			if ( 'cb' == $column_key ) {
				$class[] = 'check-column';
			} elseif ( in_array( $column_key, array( 'posts', 'comments', 'links' ) ) ) {
				$class[] = 'num';
			}

			if ( isset( $sortable[ $column_key ] ) ) {
				list( $orderby, $desc_first ) = $sortable[ $column_key ];

				if ( $current_orderby == $orderby ) {
					$order = 'asc' == $current_order ? 'desc' : 'asc';
					$class[] = 'sorted';
					$class[] = $current_order;
				} else {
					$order = $desc_first ? 'desc' : 'asc';
					$class[] = 'sortable';
					$class[] = $desc_first ? 'asc' : 'desc';
				}

				$column_display_name = '<a href="' . esc_url( add_query_arg( compact( 'orderby', 'order' ), $current_url ) ) . '"><span>' . $column_display_name . '</span><span class="sorting-indicator"></span></a>';
			}

			$id = $with_id ? "id='$column_key'" : '';

			if ( ! empty( $class ) ) {
				$class = "class='" . join( ' ', $class ) . "'";
			}

			echo "<th scope='col' $id $class $style>$column_display_name</th>";
		}
	}
}
