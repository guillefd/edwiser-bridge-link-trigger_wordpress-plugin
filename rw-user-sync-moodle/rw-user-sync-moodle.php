<?php
/*
PLugin Name: Edwiser Bridge Trigger - User Registered Auto-linker
Plugin URI: https://www.rewrite.com.ar
Description: Triggers Edwiser Bridge "link" action for every new user registered. It triggers with Wordpress core action 'user_register', so whatever it is used to create a new user, Edwiser Bridge "link" function is automatically called and user gets linked with the moodle site already setup in Edwiser Bridge plugin.  
A log file is written every time the plugin is triggered. You can check the file under the plugin folder /plugins/syncs-log.txt . (click edit in admin view and select file)
Version: 0.1
Author:  Rewrite
Author URI: https://www.rewrite.com.ar
License: Creative Commons Attribution 4.0 International
License URI: https://creativecommons.org/licenses/by/4.0/
*/

use app\wisdmlabs\edwiserBridge;

add_action( 'user_register', 'rwms_trigger_edwiser_sync', 10, 1 );

function rwms_trigger_edwiser_sync($user_id) {

	$logFile = plugin_dir_path( __DIR__ )."rw-user-sync-moodle/syncs-log.txt";

	// log userid
	error_log('created_user_id: '.$user_id, 3, $logFile);
	
	// get user object
	$user = get_userdata($user_id);
	
	// trigger Edwiser link function
	$plugin_is_active = is_plugin_active('edwiser-bridge/edwiser-bridge.php');
	
	$self = new edwiserBridge\EBUserManager();
	$linked = $self->linkMoodleUser($user);
	
	// log action
	$active = $plugin_is_active;
	error_log(' | edwiser_plugin_active: '.$active .', linked: '.$linked .' '. PHP_EOL, 3, $logFile);
	
}