<?php

namespace DSteiner23\Custom_Field_Repository\Provider;

/**
 * Interface Provider_Interface
 * @package DSteiner23\Custom_Field_Repository
 */
interface Provider_Interface {

	/**
	 * @param string $field
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function get_value($field, $post_id);

	/**
	 * @param string $field
	 * @param mixed $value
	 *
	 * @param $post_id
	 *
	 * @return $this
	 */
	public function set_value($field, $value, $post_id);

	/**
	 * @param string $name
	 * @param $options
	 *
	 * @return bool
	 */
	public function create_field_group($name, array $options = []);

	/**
	 * @param $name
	 * @param $field_group
	 * @param array $options
	 *
	 * @return bool
	 */
	public function create_field($name, $field_group, array $options = []);
}