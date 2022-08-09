<?php
add_action('init', 'create_post_project' );
function create_post_project() {
		register_post_type( 'projects',
			array(
				'labels' => array(
					'name' => __( 'Projects' ),
					'singular_name' => __( 'Project' ),
					'add_new' => __( 'Add a Project' ),
					'add_new_item' => __( 'Add a Project' ),
					'edit_item' => __( 'Edit Project' ),
					'new_item' => __( 'New Project' ),
					'view_item' => __( 'View Project' )
				),
			'public' => true,
			'has_archive' => true,
			'menu_icon'=>'dashicons-book',
			'rewrite' => array( 'slug' => 'location' ),
			'supports' => array(
					'title',
					'editor',
					'thumbnail'
				),
			)
		);
}
?>
