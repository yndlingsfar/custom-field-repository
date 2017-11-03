<?php

namespace DSteiner23\Custom_Field_Repository;

/**
 * Class Field_Group
 * @package DSteiner23\Custom_Field_Repository
 */
class Field_Group implements Field_Group_Interface {
	/**
	 * @var array
	 */
	protected $change = [];

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
	 * @@inheritdoc
	 */
	public function get_changes() {
		return $this->change;
	}
}