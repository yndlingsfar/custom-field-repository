<?php

namespace DSteiner23\Custom_Field_Repository;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Provider\ACF_Provider;


/**
 * Class Proxy_Factory
 */
class Proxy_Factory
{
	/**
	 * @param string $field_group
	 *
	 * @param $post_id
	 *
	 * @return Lazy_Load_Ghost_Proxy
	 */
	static function create($field_group, $post_id) {
		return new Lazy_Load_Ghost_Proxy(new ACF_Provider(), new Annotations(), new $field_group, $post_id);
    }
}