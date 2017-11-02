<?php
/*
Plugin Name: ACF Abstraction Layer
Plugin URI: https://danielsteiner-ws.de
Description: Provides functionality for mapping ACF groups to objects
Author: dsteiner23
Author URI: https://danielsteiner-ws.de
Version: 0.1
Text Domain: ACF Abstraction Layer
*/


function check_acf_dependecies(){
    //todo: check if ACF plugin is installed
}

//add_action('admin_menu', 'kh_jura_importer_menu'); // Call action when initialising plugin

/*
 * eine Art Repository mit set / get / flush / remove
 * wir brauchen ein Flag => isDetached oder so um zu schauen ob das Model bereits geflushed wurde
 *
 */

spl_autoload_register( 'acf_abstraction_autoloader' );
function acf_abstraction_autoloader( $class_name ) {
	$classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
	$class_file = $class_name  . '.php';
	require_once $classes_dir . $class_file;
}