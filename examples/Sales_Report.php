<?php

namespace DSteiner23\Custom_Field_Repository\Examples;

use DSteiner23\Custom_Field_Repository\Field_Group_Interface;

/**
 * @Field_Group(name="sales")
 */
class Sales_Report implements Field_Group_Interface {

	/**
	 * @var string
	 * @Field(name="report")
	 */
	private $report;

	/**
	 * @var string
	 * @Field(name="description")
	 */
	private $description;

	/**
	 * @var string
	 * @Field(name="author")
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