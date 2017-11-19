<?php
namespace Test\Fixtures;


class Annotation_Camel_Case {

	/**
	 * @var string
	 * @Field(name="report", type="text", default="test")
	 */
	private $report;

	/**
	 * @var string
	 * @Field(name="user", type="text")

	 */
	private $userName;

	/**
	 * @return string
	 */
	public function getReport() {
		return $this->report;
	}

	/**
	 * @param $report
	 */
	public function setReport( $report ) {
		$this->report = $report;
	}

	/**
	 * @return string
	 */
	public function getUserName() {
		return $this->userName;
	}

	/**
	 * @param string $userName
	 */
	public function setUserName( $userName ) {
		$this->userName = $userName;
	}
}