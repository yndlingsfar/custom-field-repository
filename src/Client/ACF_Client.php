<?php

namespace DSteiner23\Custom_Field_Repository\Client;

/**
 * Class ACF_Client
 * @package DSteiner23\Custom_Field_Repository
 */
class ACF_Client implements Client_Interface {

	/**
	 * @param string $field
	 *
	 * @return mixed
	 */
	public function get_value( $field ) {
	}

	/**
	 * @param string $field
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function set_value( $field, $value ) {
		// TODO: Implement setValue() method.
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function create_field_group( $name ) {
		// TODO: Implement createFieldGroup() method.
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public function create_field( $name ) {
		// TODO: Implement createField() method.
}}