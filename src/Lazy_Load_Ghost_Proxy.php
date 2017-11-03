<?php

namespace DSteiner23\Custom_Field_Repository;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Client\Client_Interface;

/**
 * Class Lazy_Load_Ghost_Proxy
 */
class Lazy_Load_Ghost_Proxy {
	/**
	 * @var Field_Group_Interface
	 */
	private $field_Group;

	/**
	 * @var int
	 */
	private $post_id;

	/**
	 * @var Client_Interface
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
	 * @param Client_Interface $client
	 * @param Field_Group_Interface $field_Group
	 * @param $post_id
	 * @param Annotations $annotations
	 */
	public function __construct( Client_Interface $client, Annotations $annotations, $field_Group, $post_id ) {
		$this->client      = $client;
		$this->annotations = $annotations;
		$this->field_Group = $field_Group;
		$this->post_id     = $post_id;
	}

	/**
	 * @inheritdoc
	 */
	public function is_changed( $property ) {
		return in_array( $property, $this->change );
	}

	/**
	 * @@inheritdoc
	 */
	public function add_change( $property ) {
		if ( ! $this->is_changed( $property ) ) {
			$this->change[] = $property;
		}
	}

	/**
	 * @param $name
	 * @param $arguments
	 *
	 * @return $this|mixed
	 */
	public function __call( $name, $arguments ) {

		if ( ! $this->field_Group instanceof Field_Group_Interface ) {
			throw new ProxyException( 'Invalid object provided' );
		}

		if ( method_exists( $this->field_Group, $name ) ) {

			if ( 0 === strpos( $name, 'set' ) ) {
				return $this->set_property_value( $name, $arguments[0] );
			}

			if ( 0 === strpos( $name, 'get' ) ) {
				return $this->get_property_value( $name );
			}

			return $this->field_Group->{$name}( ...$arguments );
		}

		throw new ProxyException(
			sprintf( 'Invalid function call %s', $name )
		);
	}

	public function save_to_database() {
		foreach ($this->change as $change) {
			$this->client->setValue('','' );
		}
	}

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	private function get_property_value( $name ) {
		$property_name = str_replace( [ 'get_', 'get' ], '', $name );
		$property      = $this->get_reflection_property( $property_name );

		if ( $this->is_annotated_field( $property_name ) && ! $this->is_changed( $property_name ) ) {
			$property->setValue( $this->field_Group,
				$this->client->getValue( $this->get_field_name( $property_name ) ) );
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
			throw new ProxyException( sprintf( 'Field %s not configured correctly', $property_name ) );
		}

		return $annotations['Field'][0]['name'];
	}

	private function get_field() {
		// Todo
	}
}
