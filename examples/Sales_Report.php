<?php

namespace DSteiner23\Custom_Field_Repository\Examples;

use DSteiner23\Custom_Field_Repository\Field_Group_Interface;

/**
 * @Field_Group(name="sales", title="Annual sales reports")
 */
class Sales_Report implements Field_Group_Interface { //Todo: Interface brauchen wir nicht wirklich, oder?

	/**
	 * @var string
	 * @Field(name="report", type="text", default="")
	 */
	private $report;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var string
	 */
	private $author;

	/**
	 * @return string
	 */
	public function get_report() {
		return $this->report;
	}

	/**
	 * @param $report
	 */
	public function set_report( $report ) {
		$this->report = $report;
	}

	/**
	 * @param string $author
	 * @param string $description
	 */
	public function create_report_meta( $author, $description ) {
		$this->author      = $author;
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * @return string
	 */
	public function get_author() {
		return $this->author;
	}
}