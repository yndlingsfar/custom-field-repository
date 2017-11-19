<?php

namespace DSteiner23\Custom_Field_Repository\Proxy;

use DSteiner23\Custom_Field_Repository\Field\Field_Reader;
use DSteiner23\Custom_Field_Repository\Provider\Provider_Interface;

/**
 * @package DSteiner23\Custom_Field_Repository\Proxy
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
	private $provider;

	/**
	 * @var Field_Reader
	 */
	private $reader;

	/**
	 * @var array
	 */
	protected $change = [];

	/**
	 * Lazy_Load_Ghost_Proxy constructor.
	 *
	 * @param Provider_Interface $client
	 * @param Field_Reader $reader
	 * @param $field_Group
	 * @param $post_id
	 */
	public function __construct( Provider_Interface $client, Field_Reader $reader, $field_Group, $post_id ) {
		$this->provider    = $client;
		$this->reader      = $reader;
		$this->field_Group = $field_Group;
		$this->post_id     = $post_id;
	}

	/**
	 * @param $property
	 *
	 * @return bool
	 */
	private function is_changed( $property ) {
		return in_array( $property, $this->change );
	}

	/**
	 * @param $property
	 */
	private function add_change( $property ) {
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
		if ( $this->reader->is_annotated_field( $property_name ) && ! $this->is_changed( $property_name ) ) {
			$property->setValue( $this->field_Group,
				$this->provider->get_value( $this->reader->get_field_key( $property_name ), $this->post_id ) );
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

		if ( $this->reader->is_annotated_field( $property_name ) ) {
			// add to list of changes
			$this->add_change( $property_name );
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

	public function get_field_key($property_name) {
		return $this->reader->get_field_key($property_name); // @Todo
	}

	/**
	 * @return Provider_Interface
	 */
	public function get_provider() { //@Todo
		return $this->provider;
	}
}
