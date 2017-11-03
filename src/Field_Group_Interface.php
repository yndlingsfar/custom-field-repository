<?php

namespace DSteiner23\Custom_Field_Repository;

interface Field_Group_Interface {
	/**
	 * @param $property
	 *
	 * @return boolean
	 */
	public function is_changed( $property );

	/**
	 * @param $property
	 *
	 * @return void
	 */
	public function add_change( $property );

	/**
	 * @return array
	 */
	public function get_changes();
}