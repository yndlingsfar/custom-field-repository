<?php
namespace DSteiner23\Custom_Field_Repository\Field;
use DSteiner23\Custom_Field_Repository\Proxy\Proxy_Factory;
use ProxyManager\Proxy\GhostObjectInterface;

/**
 * @package DSteiner23\Custom_Field_Repository\Field
 */
class Field_Group_Repository {

	/**
	 * @param string $entity_name
	 * @param int $post_id
	 *
	 * @return GhostObjectInterface
	 */
	public function find( string $entity_name, int $post_id ) : GhostObjectInterface{
		return Proxy_Factory::create( $entity_name, $post_id );
	}

	/**
	 * @param GhostObjectInterface $entity
	 */
	public function persist( GhostObjectInterface $entity ) { //Todo: lieber array?


//		foreach ( $entity->get_changes() as $change ) {
//			$field_group->get_provider()->set_value(
//				$field_group->get_field_key( $change ),
//				$field_group->get_property_value( $change ),
//				$field_group->get_id()
//			);
		}
//	}
}