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
	 * @param $name
	 * @param $arguments
	 *
	 * @return $this|mixed
	 */
	public function __call( $name, $arguments ) { // Überdenken
		if ( method_exists( $this->field_Group, $name ) ) {

			if ( 0 === strpos( $name, 'set' ) ) {
				$property = str_replace( 'set_', '', $name ); //Todo: neee das müssen wir anders...
				if ( $this->is_annotated_field( $property ) ) {
					$this->client->setValue( $this->get_field_name( $property ), ...$arguments );
				}

				return $this;
			}

			if ( 0 === strpos( $name, 'get' ) ) {
				$property = str_replace( 'get_', '', $name ); //Todo: neee das müssen wir anders...
				if ( $this->is_annotated_field( $property ) ) {
					return $this->client->getValue( $this->get_field_name( $property ) );
				}
			}

			return $this->field_Group->{$name}( ...$arguments );
		}

		throw new ProxyException(
			sprintf( 'Invalid function call %s', $name )
		);
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
}
