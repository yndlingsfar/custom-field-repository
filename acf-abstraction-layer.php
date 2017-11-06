<?php
/*
Plugin Name: Custom Field Repository
Plugin URI: https://danielsteiner-ws.de
Description: Provides functionality for mapping ACF groups to objects
Author: dsteiner23
Author URI: https://danielsteiner-ws.de
Version: 0.1
Text Domain: ACF Abstraction Layer
*/

use DSteiner23\Custom_Field_Repository\Field_Group_Repository;

check_dependecies();
custom_field_repository();

//Todo: rename file in custom-field-repository

function check_dependecies(){
	if (!function_exists('acf_add_local_field_group')) {
		print('The Advanced Custom Fields Pro Plugin is not installed');
	}
}

// Because registering autoloader has massive side-effects in WP
function custom_field_repository() {
	include_once 'libs/annotations/Annotations.php';
	include_once 'src/Client/Client_Interface.php';
	include_once 'src/Client/ACF_Client.php';
	include_once 'src/Field_Group_Interface.php';
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