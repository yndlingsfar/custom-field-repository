<?php
namespace DSteiner23\Custom_Field_Repository\Proxy;

/**
 * @package DSteiner23\Custom_Field_Repository\Proxy
 */
class Proxy_Exception extends \RuntimeException {
	/**
	 * @return Proxy_Exception
	 */
	static function Missing_Identifier() {
		return new self( 'The entity does not have a id field' );
	}

	static function Misconfigured_Field( $field_name ) {
		return new self( sprintf( 'Field %s not configured correctly', $field_name ) );
	}

	static function Misconfigured_Field_Group( $field_group_name ) {
		return new self( sprintf( 'Field Group %s not configured correctly', $field_group_name ) );
	}

}