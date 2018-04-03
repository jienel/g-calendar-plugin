<?php
/*
	Plugin Name: G-calendar Plugin
	Plugin URI: http://my-calendar.dev
	description: a plugin to create awesomeness and spread joy for g calendar
	Version: 1.0
	Author: Richard
	Author URI: http://thisurl.com
	License: 
*/
require(ABSPATH . WPINC . '/pluggable.php');
require_once(WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)) . "/lib/function.php");
require_once(WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)) . "/lib/google/vendor/autoload.php");
define('STDIN',fopen("php://stdin","r"));
define('APPLICATION_NAME', 'Google Calendar API PHP Quickstart');
define('CREDENTIALS_PATH', __DIR__ . '/tmp/session_calendar_user_'.get_current_user_id().'.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
define('SCOPES', implode(' ', array(
	Google_Service_Calendar::CALENDAR)
));
date_default_timezone_set('America/New_York');
add_shortcode('gcalendar', 'shortcode_gcalendar');
add_action('wp_head', 'include_js_files');
add_action('wp_head', 'add_css_files');
add_action( 'wp_ajax_get_info', 'info_request_ajax' );
add_action( 'wp_ajax_add_calendar', 'add_new_calendar' );

add_action( 'wp_enqueue_scripts', 'wpse_enqueue_datepicker' );
