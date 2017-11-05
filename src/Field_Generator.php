<?php
namespace DSteiner23\Custom_Field_Repository;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Client\Client_Interface;
/**
 * Class Field_Generator
 * @package DSteiner23\Custom_Field_Repository
 */
class Field_Generator {

	/**
	 * @var Client_Interface
	 */
	private $client;
	/**
	 * @var array
	 */
	private $field_groups;

	/**
	 * @var Annotations
	 */
	private $annotations;

	/**
	 * Field_Generator constructor.
	 *
	 * @param array $field_groups
	 * @param Client_Interface $client
	 * @param Annotations $annotations
	 */
	public function __construct(array $field_groups, Client_Interface $client, Annotations $annotations) {
		$this->field_groups = $field_groups;
		$this->client = $client;
		$this->annotations = $annotations;
	}

	public function generate() {
		$files = [];
		foreach ($this->field_groups as $field_group) {
			$object = new $field_group;

			if ($object instanceof Field_Group_Interface) {
				$files[] = $object;
				$this->create_field_group($field_group);
			}
		}



		return $files;
	}

	private function create_field_group($class) {
		$annotations = $this->annotations->getClassAnnotations($class);

		if (is_array($annotations) && array_key_exists('name', $annotations['Field_Group'][0])) {
			$this->client->create_field_group($annotations['Field_Group'][0]['name']);
		}

		print_r($annotations['Field_Group'][0]['name']);
	}

}