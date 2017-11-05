<?php

namespace DSteiner23\Custom_Field_Repository\Client;

/**
 * Interface Client_Interface
 * @package DSteiner23\Custom_Field_Repository
 */
interface Client_Interface {

	/**
	 * @param string $field
	 * @return mixed
	 */
	public function get_value($field);

	/**
	 * @param string $field
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function set_value($field, $value);

	/**
	 * @param string $name
	 * @return bool
	 */
	public function create_field_group($name);

	/**
	 * @param $name
	 * @return bool
	 */
	public function create_field($name);
}