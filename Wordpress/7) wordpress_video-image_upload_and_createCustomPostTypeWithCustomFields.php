<?php

// If user is paid, add a new tv show post

global $wpdb;
// Run the select query using $wpdb
$results = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT subscription_plan_id FROM {$wpdb->prefix}pms_member_subscriptions WHERE user_id = %d",
        $reqArr['user_id']
    )
);
// Check if any rows were returned by the query
if (count($results) > 0 && $results[0]->subscription_plan_id == 8225) {

    // User have subscription so upload video and thumbnail and add a TV Show


    $video_id = 0;
    $thumbnail_id = 0;
    if (isset($_FILES['video'])) {
        // Get the uploaded file data
        $user_video = $_FILES['video'];
        // Set the upload overrides
        $upload_overrides = array(
            'test_form' => false,
            'mimes' => array(
                'mp4' => 'video/mp4',
                'mov' => 'video/quicktime',
                'avi' => 'video/x-msvideo'
                // Add any other allowed video file types here
            ),
        );
        // Upload the video file
        $upload = wp_handle_upload($user_video, $upload_overrides);

        // Create the attachment post
        $attachment = array(
            'post_mime_type' => $upload['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($upload['file'])),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $upload['url']
        );

        $video_id = wp_insert_attachment($attachment, $upload['file']);
        $attachment_data = wp_generate_attachment_metadata($video_id, $upload['file']);
        wp_update_attachment_metadata($video_id, $attachment_data);
    }

    if (isset($_FILES['thumbnail'])) {
        // Get the uploaded file data
        $user_image = $_FILES['thumbnail'];

        // Set the upload overrides
        $upload_overrides = array(
            'test_form' => false,
            'mimes' => array(
                'jpg|jpeg|jpe' => 'image/jpeg',
                'gif' => 'image/gif',
                'png' => 'image/png',
                // Add any other allowed image file types here
            ),
        );

        // Upload the image file
        $upload = wp_handle_upload($user_image, $upload_overrides);

        // Create the attachment post
        $attachment = array(
            'post_mime_type' => $upload['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($upload['file'])),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $upload['url']
        );

        $attachment_id = wp_insert_attachment($attachment, $upload['file']);
        $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
        wp_update_attachment_metadata($attachment_id, $attachment_data);

        $thumbnail_id = $attachment_id;
    }

    // if video and thumbnail updated successfully then add TV Show
    if ($video_id !== 0 && $thumbnail_id !== 0) {

        $user = get_user_by('id', $reqArr['user_id']);

        $post_data = array(
            'post_title' => $reqArr['title'],
            'post_content' => $reqArr['caption'],
            'post_status' => 'publish',
            'post_author' => $user->ID,
            'post_type' => 'tv_show',
        );

        // Insert the post
        $post_id = wp_insert_post($post_data);

        // add custom fields
        update_field('key_trailer_img', $thumbnail_id, $post_id);
        update_field('key_logo', $thumbnail_id, $post_id);
        update_field('key_upload_item', $video_id, $post_id);
        update_field('key_download_btn', 'upload', $post_id);

        // add genre
        global $wpdb;
        $table_name = $wpdb->prefix . "term_relationships";
        $wpdb->insert(
            $table_name,
            array(
                'object_id' => $post_id,
                'term_taxonomy_id' => $reqArr['genre_id']
            )
        );
        $response['proUserStatus'] = "TV Show added for Pro User";
    }

} else {
    // User doesn't have subscription
    $response['proUserStatus'] = "User doesn't have subscription";
}