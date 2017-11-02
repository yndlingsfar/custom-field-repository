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
	public function getValue( $field ) {
		// TODO: Implement getValue() method.
	}

	/**
	 * @param string $field
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function setValue( $field, $value ) {
		// TODO: Implement setValue() method.
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function createFieldGroup( $name ) {
		// TODO: Implement createFieldGroup() method.
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public function createField( $name ) {
		// TODO: Implement createField() method.
}}