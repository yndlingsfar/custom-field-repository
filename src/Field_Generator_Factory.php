<?php
namespace DSteiner23\Custom_Field_Repository;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Client\ACF_Client;

/**
 * Class Field_Generator_Factory
 * @package DSteiner23\Custom_Field_Repository
 */
class Field_Generator_Factory {
	static function create(array $field_groups) {
		return new Field_Generator($field_groups, new ACF_Client(), new Annotations());
	}
}