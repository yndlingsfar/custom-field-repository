<?php

namespace DSteiner23\Custom_Field_Repository\Examples;

use DSteiner23\Custom_Field_Repository\Field_Group_Interface;

/**
 * Class Test
 */
class Sales_Report implements Field_Group_Interface {

    /**
     * @var string
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
	public function get_report()
	{
		return $this->report;
	}

    /**
     * @param $report
     */
	public function set_report($report)
    {
        $this->report = $report;
    }

	/**
	 * @param string $author
	 * @param string $description
	 */
	public function create_report_meta($author, $description)
	{
		$this->author = $author;
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

	public function isChanged()
	{
		// TODO: Implement isChanged() method.
	}
}