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
	public function getValue($field);

	/**
	 * @param string $field
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function setValue($field, $value);

	/**
	 * @param string $name
	 * @return bool
	 */
	public function createFieldGroup($name);

	/**
	 * @param $name
	 * @return bool
	 */
	public function createField($name);
}