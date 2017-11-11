<?php

namespace Test\Fixtures;

/**
 * @Field_Group(name="sales", title="Annual sales reports")
 */
class Annotation_Valid {

	/**
	 * @var string
	 * @Field(name="report", type="text", default="test")
	 */
	private $report;

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
}