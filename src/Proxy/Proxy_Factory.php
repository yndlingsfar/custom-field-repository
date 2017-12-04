<?php

namespace DSteiner23\Custom_Field_Repository\Proxy;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Field\Field_Reader;
use DSteiner23\Custom_Field_Repository\Provider\Provider_Manager;
use ProxyManager\Factory\LazyLoadingGhostFactory;
use ProxyManager\Proxy\GhostObjectInterface;


/**
 * @package DSteiner23\Custom_Field_Repository\Proxy
 */
class Proxy_Factory {

	/**
	 * @param string $entity_name
	 * @param int $post_id
	 *
	 * @return GhostObjectInterface
	 */
	static function create( string $entity_name, int $post_id ): GhostObjectInterface {
		$annotations      = new Annotations();
		$provider_manager = new Provider_Manager( $annotations, $entity_name );
		$field_reader     = new Field_Reader( $annotations, $entity_name );
		$provider         = $provider_manager->getProvider();


		$factory     = new LazyLoadingGhostFactory();
		$initializer = function (
			GhostObjectInterface $ghostObject,
			string $method,
			array $parameters,
			& $initializer,
			array $properties
		) use ( $provider, $field_reader, $post_id ) {
			$initializer = null; // disable initialization

			if ( $post_id ) {
				foreach ( $properties as $key => $property ) {
					$split         = preg_split( '/\\0/', $key, - 1, PREG_SPLIT_NO_EMPTY );
					$property_name = end( $split );

					if ($field_reader->is_identifier($property_name)) {
						$proxyOptions = [
							'skippedProperties' => [
								$key,
							],
						];

						continue;
					}

					if ( $field_reader->is_annotated_field( $property_name ) ) {
						$properties[ $key ] = $provider->get_value( $field_reader->get_field_key( $property_name ), $post_id );
					}

				}
			}

			return true; // confirm that initialization occurred correctly
		};

		$ghostObject = $factory->createProxy( $entity_name, $initializer );

		try {
			$idReflection = new \ReflectionProperty($entity_name, 'id');
			$idReflection->setAccessible(true);
			$idReflection->setValue($ghostObject, $post_id);
		} catch (\ReflectionException $e) {
			throw Proxy_Exception::Missing_Identifier();
		}

		return $ghostObject;
	}
}