<?php

namespace DSteiner23\Custom_Field_Repository\Client;

/**
 * Class ACF_Client
 * @package DSteiner23\Custom_Field_Repository
 */
class ACF_Client implements Client_Interface {

	/**
	 * @inheritdoc
	 */
	public function get_value( $field, $post_id ) {
		return get_field( $field, $post_id );
	}

	/**
	 * @inheritdoc
	 */
	public function set_value( $field, $value, $post_id ) {
		update_field( $field, $value, $post_id );
	}

	/**
	 * @inheritdoc
	 */
	public function create_field_group( $name, array $options = [] ) {
		acf_add_local_field_group( [
			'key'      => sprintf( 'group_%s', $name ),
			'title'    => isset( $options['title'] ) ? $options['title'] : $name,
			'fields'   => [],
			'location' => [
				[
					[
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'post',
					],
				],
			],
		] );
	}

	/**
	 * @inheritdoc
	 */
	public function create_field( $name, $field_group, array $options = [] ) {
		$field_name = sprintf( '%s.%s', $field_group, $name );
		acf_add_local_field( [
			'key'           => sprintf( 'field_%s', md5( $field_name ) ),
			'label'         => $field_name,
			'name'          => sprintf( '%s.%s', $field_group, $name ),
			'type'          => isset( $options['type'] ) ? $options['type'] : 'text',
			'parent'        => $field_group,
			'default_value' => isset( $options['default'] ) ? $options['default'] : '',
		] );
	}
}