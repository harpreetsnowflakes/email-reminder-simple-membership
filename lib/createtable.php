<?php
global $wpdb;
$table_name = $wpdb->prefix . 'swpm_check_reminder';

$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	user_id mediumint(9) NOT NULL,
	date varchar(20) NOT NULL,
	UNIQUE KEY id (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );


?>