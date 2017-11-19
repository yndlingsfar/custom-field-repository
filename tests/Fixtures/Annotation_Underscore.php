<?php

namespace Test\Fixtures;

/**
 * @Field_Group(name="sales", title="Annual sales reports")
 */
class Annotation_Underscore {

	/**
	 * @var string
	 * @Field(name="report", type="text", default="test")
	 */
	private $report;

	/**
	 * @var string
	 * @Field(name="user", type="text")

	 */
	private $user_name;

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
	 * @return string
	 */
	public function get_user_name() {
		return $this->user_name;
	}

	/**
	 * @param string $user_name
	 */
	public function set_user_name( $user_name ) {
		$this->user_name = $user_name;
	}

}