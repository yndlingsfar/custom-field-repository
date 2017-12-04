<?php

namespace DSteiner23\Custom_Field_Repository\Field;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Proxy\Proxy_Exception;

/**
 * @package DSteiner23\Custom_Field_Repository\Field
 */
class Field_Reader {
	const KEY_NAME = 'name';

	/**
	 * @var Annotations
	 */
	private $annotations;

	/**
	 * @var string
	 */
	private $field_group;

	/**
	 * @param Annotations $annotations
	 * @param string $field_group
	 */
	public function __construct( Annotations $annotations, $field_group ) {
		$this->annotations = $annotations;
		$this->field_group = $field_group;
	}

	/**
	 * @param $property
	 *
	 * @return bool
	 */
	public function is_annotated_field( $property ): bool {
		$annotations = $this->annotations->getPropertyAnnotations( $this->field_group, $property );

		return is_array( $annotations ) && array_key_exists( 'Field', $annotations );
	}

	/**
	 * @param $property
	 *
	 * @return bool
	 */
	public function is_identifier( $property ): bool {
		$annotations = $this->annotations->getPropertyAnnotations( $this->field_group, $property );

		return is_array( $annotations ) && array_key_exists( 'Id', $annotations );
	}


	/**
	 * @param $property
	 *
	 * @return string
	 */
	public function get_field_name( $property ): string {
		$annotations = $this->annotations->getPropertyAnnotations( $this->field_group, $property );
		if ( ! is_array( $annotations ) || ! array_key_exists( self::KEY_NAME, $annotations['Field'][0] ) ) {
			throw Proxy_Exception::Misconfigured_Field( $property );
		}

		return $annotations['Field'][0][ self::KEY_NAME ];
	}

	/**
	 * @return string
	 */
	public function get_field_group_name(): string {
		$annotations = $this->annotations->getClassAnnotations( $this->field_group );
		if ( ! is_array( $annotations ) || ! array_key_exists( 'name', $annotations['Field_Group'][0] ) ) {
			throw Proxy_Exception::Misconfigured_Field_Group( $this->field_group );
		}

		return $annotations['Field_Group'][0][ self::KEY_NAME ];
	}

	/**
	 * @param $property_name
	 *
	 * @return string
	 */
	public function get_field_key( $property_name ) {
		return sprintf( '%s.%s', $this->get_field_group_name(), $this->get_field_name( $property_name ) );
	}
}
