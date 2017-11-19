<?php

namespace DSteiner23\Custom_Field_Repository\Proxy;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Field\Field_Reader;
use DSteiner23\Custom_Field_Repository\Provider\Provider_Manager;


/**
 * @package DSteiner23\Custom_Field_Repository\Proxy
 */
class Proxy_Factory {
	/**
	 * @param string $field_group
	 *
	 * @param $post_id
	 *
	 * @return Lazy_Load_Ghost_Proxy
	 */
	static function create( $field_group, $post_id ) {
		$annotations      = new Annotations();
		$provider_manager = new Provider_Manager( $annotations, $field_group );
		$field_reader = new Field_Reader($annotations, $field_group);

		return new Lazy_Load_Ghost_Proxy( $provider_manager->getProvider(), $field_reader, new $field_group, $post_id );
	}
}