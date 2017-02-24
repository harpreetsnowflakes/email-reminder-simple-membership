<?php

/*
Plugin Name: Remind simple-membership
Description: Email Reminder Module for simple-membership
Author: PreeT PanesaR
Version: 1.0
License: GPLv2
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function plugin_activate() {
	include( plugin_dir_path( __FILE__ ) . 'lib/createtable.php');
	if (! wp_next_scheduled ( 'send_mail_once' )) {
	wp_schedule_event(time(), 'daily', 'send_mail_once');
	wp_schedule_event(time(), '5min', 'send_mail_everyfive');
    }
}
register_activation_hook( __FILE__, 'plugin_activate' );
add_action('send_mail_once', 'do_this_daily');
add_action('send_mail_everyfive', 'send_mail_everyfive_minute');

function do_this_daily()
{
	require_once(ABSPATH . 'wp-load.php');
	include_once( plugin_dir_path( __FILE__ ) . 'include/cronfunction.php');
	mycronset();
}

function send_mail_everyfive_minute()
{
	require_once(ABSPATH . 'wp-load.php');
	include_once( plugin_dir_path( __FILE__ ) . 'include/cronminute.php');
	mycronfiveminute();
}

function load_plugin_files() {
        
}
add_action( 'admin_init', 'load_plugin_files' );


function wp_email_reminder_addon(){
    include( plugin_dir_path( __FILE__ ) . 'include/menu.php');
	//include( plugin_dir_path( __FILE__ ) . 'lib/createtable.php');
}
add_action('plugins_loaded', 'wp_email_reminder_addon');


function itg_admin_css_all_page() {
    wp_register_style($handle = 'itg-admin-css-all', $src = plugins_url('css/styletable.css', __FILE__), $deps = array(), $ver = '1.0.0', $media = 'all');
    wp_enqueue_style('itg-admin-css-all');
}

add_action('admin_print_styles', 'itg_admin_css_all_page');

function my_cron_schedules($schedules){
    if(!isset($schedules["5min"])){
        $schedules["5min"] = array(
            'interval' => 5*60,
            'display' => __('Once every 5 minutes'));
    }
    if(!isset($schedules["30min"])){
        $schedules["30min"] = array(
            'interval' => 30*60,
            'display' => __('Once every 30 minutes'));
    }
    return $schedules;
}
add_filter('cron_schedules','my_cron_schedules');




register_deactivation_hook(__FILE__, 'my_deactivation');
function my_deactivation() {
	wp_clear_scheduled_hook('send_mail_once');
	wp_clear_scheduled_hook('send_mail_everyfive');
}









?>