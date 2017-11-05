<?php
namespace DSteiner23\Custom_Field_Repository;

/**
 * Class Field_Group_Repository
 */
class Field_Group_Repository {

	/**
	 * Contains all field groups that have been returned by the find method
	 * @var array
	 */
	private $field_group_storage;

	public function __construct() {
		$this->field_group_storage = [];
	}

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
	public function persist(Lazy_Load_Ghost_Proxy $field_group) {
		foreach ($field_group->get_changes() as $change) {
			$field_group->getClient()->set_value($change, 'blabla', $field_group->get_id()); // Todo
		}
	}
}