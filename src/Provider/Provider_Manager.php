<?php

namespace DSteiner23\Custom_Field_Repository\Provider;

use Alchemy\Component\Annotations\Annotations;

/**
 * @package DSteiner23\Custom_Field_Repository\Provider
 */
class Provider_Manager
{
	const PROVIDER_NATIVE = 'native';
	const PROVIDER_ACF = 'acf';
	const PROVIDER_KEY = 'provider';

	/**
	 * @var Annotations
	 */
	private $annotations;

	/**
	 * @var string
	 */
	private $field_group;

	public function __construct(Annotations $annotations, $field_group)
    {
	    $this->annotations = $annotations;
	    $this->field_group = $field_group;
    }

    public function getProvider()
    {
        $annotations = $this->annotations->getClassAnnotations($this->field_group);

        if (is_array( $annotations ) && array_key_exists('Field_Group', $annotations)) {

	        if (array_key_exists(self::PROVIDER_KEY, $annotations['Field_Group'][0])
	            && $annotations['Field_Group'][0][self::PROVIDER_KEY] == self::PROVIDER_ACF) {
	        	return new ACF_Provider();
	        }

        }

        return new Native_Provider();
    }
}
