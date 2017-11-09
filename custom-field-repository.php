<?php
/*
Plugin Name: Loki - Custom Field Repository
Plugin URI: https://danielsteiner-ws.de
Description: Provides functionality for mapping ACF groups to objects
Author: dsteiner23
Author URI: https://danielsteiner-ws.de
Version: 1.0
Text Domain: LOKI - Custom Field Repository
*/

use DSteiner23\Custom_Field_Repository\Field_Group_Repository;

custom_field_repository();

register_activation_hook( __FILE__, 'check_dependecies' );
function check_dependecies(){
	if (!function_exists('acf_add_local_field_group')) {
		$error_message = 'The Advanced Custom Fields Pro Plugin is not installed';
		die($error_message);
	}
}

function custom_field_repository() {
	include_once 'libs/annotations/Annotations.php';
	include_once 'src/Client/Client_Interface.php';
	include_once 'src/Client/ACF_Client.php';
	include_once 'src/Field_Group_Repository.php';
	include_once 'src/Field_Generator_Factory.php';
	include_once 'src/Field_Generator.php';
	include_once 'src/Lazy_Load_Ghost_Proxy.php';
	include_once 'src/Proxy_Factory.php';
	include_once 'src/Proxy_Exception.php';
}

function register_custom_field_repository ($field_groups) {
	if (is_array($field_groups)) {
		$field_generator = \DSteiner23\Custom_Field_Repository\Field_Generator_Factory::create($field_groups);
		$field_generator->generate();
	}
}

function get_custom_field_repository() {
	return new Field_Group_Repository();
}