<?php

namespace DSteiner23\Custom_Field_Repository\Provider;

/**
 * Class Native_Provider
 * @package DSteiner23\Custom_Field_Repository\Provider
 */
class Native_Provider implements Provider_Interface
{
	/**
	 * @param string $field
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function get_value( $field, $post_id ) {
		$value = get_post_custom_values($field, $post_id);

		return $value[0]; // Todo: richtig so?
	}

	/**
	 * @param string $field
	 * @param mixed $value
	 *
	 * @param $post_id
	 *
	 * @return $this
	 */
	public function set_value( $field, $value, $post_id ) {
		if ( ! add_post_meta( $post_id, $field, $value, true ) ) {
			update_post_meta( $post_id, $field, $value );
		}
	}

	/**
	 * @param string $name
	 * @param $options
	 *
	 * @return bool
	 */
	public function create_field_group( $name, array $options = [] ) {
		// Generation of field groups not supported in NativeProvider
	}

	/**
	 * @param $name
	 * @param $field_group
	 * @param array $options
	 *
	 * @return bool
	 */
	public function create_field( $name, $field_group, array $options = [] ) {
		// Preparing of fields not supported / required in NativeProvider
	}
}
