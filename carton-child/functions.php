<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'ms_theme_editor_parent_css' ) ):
	function ms_theme_editor_parent_css() {
		wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
	}
endif;
add_action( 'wp_enqueue_scripts', 'ms_theme_editor_parent_css', 10 );

// END ENQUEUE PARENT ACTION

// loading the script for the social share popup
function my_scripts_method() {
	wp_enqueue_script(
		'custom-script',
		get_stylesheet_directory_uri() . '/js/pop.js',
		array( 'jquery' )
	);
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

// This was my intial hack to modify the site RSS feed to include some hashtags for when new posts are shared by the dlvr.it service
// ... adding hashtags is an option in dlvr.it but this is part of their premium package 
function add_tags_in_feed($title) {
		$title = $title . ' #GSuiteDevs #GoogleAppsScript';
	return $title;
}
add_filter('the_title_rss', 'add_tags_in_feed');

// This is the latest mod to the RSS feed which adds a mention to tagged authors and contributor Twitter handles
add_action('init', 'customRSS');
function customRSS(){
    add_feed('twitter', 'customRSSFunc');
}

function customRSSFunc(){
    get_template_part('rss-twitter', 'twitter');
}

// The following block tidies up some of the wp-admin to hide stuff from Contributors 
function remove_dashboard_widgets() {
	global $wp_meta_boxes; 
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
function wpse239532_load_admin_style() {
	wp_enqueue_style( 'admin_css', get_stylesheet_directory_uri() . '/css/admin.css', false, '1.0.3' );
}
if (!current_user_can('manage_options')) {
	add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
	add_action( 'admin_enqueue_scripts', 'wpse239532_load_admin_style' );
}