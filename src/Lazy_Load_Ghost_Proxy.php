<?php

namespace DSteiner23\Custom_Field_Repository;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Provider\Provider_Interface;

/**
 * Class Lazy_Load_Ghost_Proxy
 */
class Lazy_Load_Ghost_Proxy {
	/**
	 * @var object
	 */
	private $field_Group;

	/**
	 * @var int
	 */
	private $post_id;

	/**
	 * @var Provider_Interface
	 */
	private $client;

	/**
	 * @var Annotations
	 */
	private $annotations;

	/**
	 * @var array
	 */
	protected $change = [];

	/**
	 * Lazy_Load_Ghost_Proxy constructor.
	 *
	 * @param Provider_Interface $client
	 * @param object $field_Group
	 * @param $post_id
	 * @param Annotations $annotations
	 */
	public function __construct( Provider_Interface $client, Annotations $annotations, $field_Group, $post_id ) {
		$this->client      = $client;
		$this->annotations = $annotations;
		$this->field_Group = $field_Group;
		$this->post_id     = $post_id;
	}

	/**
	 * @param $property
	 *
	 * @return bool
	 */
	public function is_changed( $property ) {
		return in_array( $property, $this->change );
	}

	/**
	 * @param $property
	 */
	public function add_change( $property ) {
		if ( ! $this->is_changed( $property ) ) {
			$this->change[] = $property;
		}
	}

	/**
	 * @return array
	 */
	public function get_changes() {
		return $this->change;
	}

	/**
	 * @return int
	 */
	public function get_id() {
		return $this->post_id;
	}

	/**
	 * @param $name
	 * @param $arguments
	 *
	 * @return $this|mixed
	 */
	public function __call( $name, $arguments ) {

		if ( method_exists( $this->field_Group, $name ) ) {

			if ( 0 === strpos( $name, 'set' ) ) {
				return $this->set_property_value( $name, $arguments[0] );
			}

			if ( 0 === strpos( $name, 'get' ) ) {
				return $this->get_property_value( $name );
			}

			return $this->field_Group->{$name}( ...$arguments );
		}

		throw new Proxy_Exception(
			sprintf( 'Invalid function call %s', $name )
		);
	}

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function get_property_value( $name ) {
		$property_name = str_replace( [ 'get_', 'get' ], '', $name );
		$property      = $this->get_reflection_property( $property_name );

		if ( $this->is_annotated_field( $property_name ) && ! $this->is_changed( $property_name ) ) {
			$property->setValue( $this->field_Group,
				$this->client->get_value( $this->get_property_path( $property_name ), $this->post_id ) );
		}

		return $property->getValue( $this->field_Group );
	}

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return mixed
	 */
	private function set_property_value( $name, $value ) {
		$property_name = str_replace( [ 'set_', 'set' ], '', $name );
		$property      = $this->get_reflection_property( $property_name );

		if ( $this->is_annotated_field( $property_name ) ) {
			// add to list of changes
			$this->add_change( $property_name ); // Hier ein Objekt vom Typ FIELD hinzufügen
			$property->setValue( $this->field_Group, $value );
		}

		return $this->field_Group->{$name}( $value );
	}

	/**
	 * @param $property_name
	 *
	 * @return \ReflectionProperty
	 */
	private function get_reflection_property( $property_name ) {
		$reflectionClass = new \ReflectionClass( get_class( $this->field_Group ) );
		$property        = $reflectionClass->getProperty( $property_name );
		$property->setAccessible( true );

		return $property;
	}

	/**
	 * @param $property_name
	 *
	 * @return bool
	 */
	private function is_annotated_field( $property_name ) {
		$annotations = $this->get_annotations( $property_name );

		return is_array( $annotations ) && array_key_exists( 'Field', $annotations );
	}

	/**
	 * @param $property_name
	 *
	 * @return array
	 */
	private function get_annotations( $property_name ) {
		return $this->annotations->getPropertyAnnotations(
			get_class( $this->field_Group ),
			$property_name
		);
	}

	/**
	 * @param $property_name
	 *
	 * @return string
	 */
	private function get_field_name( $property_name ) {
		$annotations = $this->get_annotations( $property_name );

		if ( ! is_array( $annotations ) || ! array_key_exists( 'name', $annotations['Field'][0] ) ) {
			throw new Proxy_Exception( sprintf( 'Field %s not configured correctly', $property_name ) );
		}

		return $annotations['Field'][0]['name'];
	}

	/**
	 * @return string
	 */
	private function get_field_group_name() {
		$annotations = $this->annotations->getClassAnnotations(
			get_class( $this->field_Group )
		);

		if ( ! is_array( $annotations ) || ! array_key_exists( 'name', $annotations['Field_Group'][0] ) ) {
			throw new Proxy_Exception( sprintf( 'Field_Group %s not configured correctly' ) );
		}

		return $annotations['Field_Group'][0]['name'];
	}

	/**
	 * Returns combination if field_group_name and field_name e.g. field_group.field
	 *
	 * @param $property_name
	 *
	 * @return string
	 */
	public function get_property_path( $property_name ) {
		return sprintf( '%s.%s', $this->get_field_group_name(), $this->get_field_name( $property_name ) );
	}

	/**
	 * @return Provider_Interface
	 */
	public function get_client() {
		return $this->client;
	}
}
