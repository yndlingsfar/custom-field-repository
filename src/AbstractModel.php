<?php

namespace Core\Models;
use Core\Query;

/**
 * Class AbstractModel
 * @package Core\Models
 */
abstract class AbstractModel {

	/**
	 * @var integer
	 */
	protected $id;

	/**
	 * @var array
	 */
	protected $changed = [];

	const UNDEFINED = 'unbekannt';

	/**
	 * @param null $id
	 */
	public function __construct($id = null) {
		$this->id = $id;
	}

	/**
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param string $status
	 *
	 * @return $this
	 */
	protected function flush($status = Query::STATUS_PUBLISHED) {

		$this->id = Model::addPost($this->getTitle(), $this->getName(), $status);

		foreach($this->changed as $key => $value) {
			Model::update($key, $value, $this->id);
		}

		return $this;
	}

	/**
	 * @param $selector
	 * @param $property
	 * @param bool|false $time
	 *
	 * @return int|mixed|null|void
	 */
	protected function get($selector, &$property, $time = false) {

		if (!$property) {
			if ($this->id) {
				//lazy loading
				if ($time) {
					$property = Model::getTime($selector, $this->id);
				} else {
					$property = Model::get($selector, $this->id);
				}
			} else {
				return null;
			}
		}

		return $property;
	}

	/**
	 * @param $selector
	 * @param $value
	 * @param $property
	 */
	protected function set($selector, $value, &$property) {
		$this->changed[$selector] = $value;

		$property = $value;
	}

	/**
	 * @param $selector
	 * @param $value
	 */
	protected function setReference($selector, $value) {
		$this->changed[$selector] = $value;
	}

	/**
	 * @return string
	 */
	abstract public function getName();

	/**
	 * @return string
	 */
	abstract public function getTitle();
}