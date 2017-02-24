<?php

// function user_reminder_do_admin_menu($menu_parent_slug){
	// add_submenu_page($menu_parent_slug, __("Email Reminder", 'swpm'), __("Email Reminder", 'swpm'), 'manage_options', 'swpm-wp-email-reminder', $function = 'email_reminder');
// }
	// add_action('swpm_after_main_admin_menu', 'user_reminder_do_admin_menu' );

// function email_reminder()
// {
		// echo "Hello";
// }

include_once ('meta-boxes.php');

if ( ! function_exists('register_email_reminder') ) {
  // Register our post type
  function register_email_reminder() {
    // Set label names for the WP backend UI
    $labels = array(
      'name'                => _x( 'Email Reminder', 'Post Type General Name', 'text_domain' ),
      'singular_name'       => _x( 'Email Reminder', 'Post Type Singular Name', 'text_domain' ),
      'menu_name'           => __( 'Email Reminders', 'text_domain' ),
      'parent_item_colon'   => __( 'Parent Email Reminder', 'text_domain' ),
      'all_items'           => __( 'All Email Reminders', 'text_domain' ),
      'view_item'           => __( 'View Email Reminder', 'text_domain' ),
      'add_new_item'        => __( 'Add New Email Reminder', 'text_domain' ),
      'add_new'             => __( 'Add New', 'text_domain' ),
      'edit_item'           => __( 'Edit Email Reminder', 'text_domain' ),
      'update_item'         => __( 'Update Email Reminder', 'text_domain' ),
      'search_items'        => __( 'Search Email Reminder', 'text_domain' ),
      'not_found'           => __( 'Not Found', 'text_domain' ),
      'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' )
    );
    // Set post type options
    $args = array(
      'label'               => __( 'reminders', 'text_domain' ),
      'description'         => __( 'My list of reminders', 'text_domain' ),
      'labels'              => $labels,
      'supports'            => array( 'title'),
      'taxonomies'          => array(),
      'hierarchical'        => false,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'menu_position'       => 5,
      'menu_icon'           => 'dashicons-email-alt',
      'show_in_admin_bar'   => true,
      'show_in_nav_menus'   => true,
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'capability_type'     => 'post'
    );
    register_post_type( 'email-reminder', $args );
	
	
  }
  add_action( 'init', 'register_email_reminder', 0 );
}

add_action('swpm_after_main_admin_menu', 'my_wp_sub_menu'); 
function my_wp_sub_menu($menu_parent_slug) { 
    add_submenu_page($menu_parent_slug,__("Email Reminder", 'swpm'),  __("Email Reminder", 'swpm'), 'manage_options', 'edit.php?post_type=email-reminder'); 
}  

function custom_menu_page_removing() {
    remove_menu_page( 'edit.php?post_type=email-reminder' );
	remove_meta_box('swpm_sectionid', 'email-reminder', 'advanced');
}
add_action( 'admin_menu', 'custom_menu_page_removing' );


function change_publish_btn_txt() {
    echo "<script type='text/javascript'>jQuery(document).ready(function(){
        jQuery('#publish').attr('value', 'Add Email Reminder');
    });</script>";
}
add_action('admin_footer-post-new.php', 'change_publish_btn_txt', 99);



function work_meta_box( $post ){
    //variables
    $id = 'work_info';
    $title = 'Work Information';
    $callback = create_work_meta;
    $screen = 'email-reminder';
    $context = 'normal';
    $priority = 'high';
    add_meta_box( $id, $title, $callback, $screen, $context, $priority );
}
add_action( 'add_meta_boxes_email-reminder', 'work_meta_box' );







?>