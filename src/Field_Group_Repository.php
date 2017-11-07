<?php
namespace DSteiner23\Custom_Field_Repository;

/**
 * Class Field_Group_Repository
 */
class Field_Group_Repository {

	/**
	 * @param $class
	 * @param $post_id
	 *
	 * @return Lazy_Load_Ghost_Proxy
	 */
	public function find( $class, $post_id ) {
		return Proxy_Factory::create( $class, $post_id );
	}

	/**
	 * @param Lazy_Load_Ghost_Proxy $field_group
	 */
	public function persist( Lazy_Load_Ghost_Proxy $field_group ) { //Todo: lieber array?
		foreach ( $field_group->get_changes() as $change ) {
			$field_group->get_client()->set_value(
				$field_group->get_property_path( $change ),
				$field_group->get_property_value( $change ),
				$field_group->get_id()
			);
		}
	}
}