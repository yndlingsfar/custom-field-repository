<?php
/*
Plugin Name: Loki - Custom Field Repository
Plugin URI: https://danielsteiner-ws.de
Description: Provides functionality for mapping ACF groups to objects
Author: dsteiner23
Author URI: https://danielsteiner-ws.de
Version: 1.0
Text Domain: LOKI - Custom Field Repository
License: GPL2
Loki - Custom Field Repository is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Loki - Custom Field Repository is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Loki - Custom Field Repository.
*/

use DSteiner23\Custom_Field_Repository\Field_Group_Repository;

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
custom_field_repository();

function custom_field_repository() {
	include_once 'libs/annotations/Annotations.php';
	include_once 'src/Provider/Provider_Interface.php';
	include_once 'src/Provider/ACF_Provider.php';
	include_once 'src/Provider/Native_Provider.php';
	include_once 'src/Provider/Provider_Manager.php';
	include_once 'src/Field_Group_Repository.php';
	include_once 'src/Field_Generator_Factory.php';
	include_once 'src/Field_Generator.php';
	include_once 'src/Lazy_Load_Ghost_Proxy.php';
	include_once 'src/Proxy_Factory.php';
	include_once 'src/Proxy_Exception.php';
	include_once 'src/Field_Generator_Exception.php';
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