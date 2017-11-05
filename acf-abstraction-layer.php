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

check_dependecies();
custom_field_repository();
process_entitites();

function check_dependecies(){
//	if (!function_exists('acf_add_local_field_group')) {
//		throw new \Exception('The Advanced Custom Fields Plugin is not installed');
//	}
}

// Because registering autoloader has massive side-effects in WP
function custom_field_repository() {
	include_once 'libs/annotations/Annotations.php';
	include_once 'src/Client/Client_Interface.php';
	include_once 'src/Client/ACF_Client.php';
	include_once 'src/Field.php';
	include_once 'src/Field_Group_Interface.php';
	include_once 'src/Field_Group_Repository.php';
	include_once 'src/Lazy_Load_Ghost_Proxy.php';
	include_once 'src/Proxy_Factory.php';
	include_once 'src/ProxyException.php';
}

function process_entitites () {
	$dir = new DirectoryIterator(dirname(__FILE__));
	foreach ($dir as $fileinfo) {
		if (!$fileinfo->isDot()) {
			var_dump($fileinfo->getFilename());
		}
	}
}