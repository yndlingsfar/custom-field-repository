<?php

namespace DSteiner23\Custom_Field_Repository;

use DSteiner23\Custom_Field_Repository\Client\Client_Interface;

/**
 * Class Lazy_Load_Ghost_Proxy
 */
class Lazy_Load_Ghost_Proxy {
	/**
	 * @var Field_Group_Interface
	 */
	private $field_Group;

	/**
	 * @var int
	 */
	private $post_id;

	/**
	 * @var Client_Interface
	 */
	private $client;

	/**
	 * Lazy_Load_Ghost_Proxy constructor.
	 *
	 * @param Client_Interface $client
	 * @param Field_Group_Interface $field_Group
	 * @param $post_id
	 */
	public function __construct(Client_Interface $client, $field_Group, $post_id) {
		$this->client = $client;
		$this->field_Group = $field_Group;
		$this->post_id = $post_id;
	}

	/**
	 * @param $name
	 * @param $arguments
	 *
	 * @return $this|mixed
	 */
	public function __call( $name, $arguments ) {
        if (method_exists($this->field_Group, $name)) {

	        if (0 === strpos($name, 'set')) { //Todo: Das muss über Annotations angesteuert werden
	        	//Todo: Hier brauchen wir den annotation reader
		        $this->client->setValue('irgendwas', ...$arguments);
		        return $this;
	        }

	        if (0 === strpos($name, 'get')) { //Todo: Das muss über Annotations angesteuert werden
		        //Todo: Hier brauchen wir den annotation reader
		        return $this->client->getValue('irgendwas');
	        }

            return $this->field_Group->{$name}(...$arguments);
        }

        throw new ProxyException(
            sprintf('Invalid function call %s', $name)
        );
	}
}
