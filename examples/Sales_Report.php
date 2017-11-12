<?php

namespace DSteiner23\Custom_Field_Repository\Examples;

/**
 * @Field_Group(name="sales", title="Annual sales reports", provider="acf")
 */
class Sales_Report {

	/**
	 * @var string
	 * @Field(name="report", type="text", default="test")
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