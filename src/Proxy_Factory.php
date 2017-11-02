<?php

namespace DSteiner23\Custom_Field_Repository;

use DSteiner23\Custom_Field_Repository\Client\ACF_Client;

/**
 * Class Proxy_Factory
 */
class Proxy_Factory
{
	/**
	 * @param Field_Group_Interface $field_group
	 *
	 * @param $post_id
	 *
	 * @return Lazy_Load_Ghost_Proxy
	 */
	static function create($field_group, $post_id) {
		return new Lazy_Load_Ghost_Proxy(new ACF_Client(), new $field_group, $post_id);
    }
}