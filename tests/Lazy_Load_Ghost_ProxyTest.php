<?php

namespace Test;

use DSteiner23\Custom_Field_Repository\Client\Client_Interface;
use DSteiner23\Custom_Field_Repository\Examples\Sales_Report;
use DSteiner23\Custom_Field_Repository\Lazy_Load_Ghost_Proxy;
use DSteiner23\Custom_Field_Repository\ProxyException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class Lazy_Load_Ghost_ProxyTest extends TestCase {
	/**
	 * @var Sales_Report
	 */
	private $report;

	/**
	 * @var ObjectProphecy
	 */
	private $client;


	public function setUp() {
		parent::setUp();

		$this->client = $this->prophesize(
			Client_Interface::class
		);

		$this->report = new Lazy_Load_Ghost_Proxy(
			$this->client->reveal(),
			new Sales_Report(),
			1
		);
	}

	public function test_call_unknown_function() {
		self::expectExceptionMessage( ProxyException::class );
		self::expectExceptionMessage( 'Invalid function call get_test' );
		$this->report->get_test();
	}

	public function test_single_param_setter() {
		$this->report->set_report('I am a report');
		self::assertSame('I am a report', $this->report->get_report());
	}

	public function test_multi_param_function() {
		$this->report->create_report_meta('Author', 'This is a test');
		self::assertSame('Author', $this->report->get_author());
		self::assertSame('This is a test', $this->report->get_description());
	}

	public function test_get_custom_field_value() {
		$this->client->getValue(Argument::type('string'))->shouldBeCalled();

		$this->report->get_author();
	}

	public function test_set_custom_field_value() {
		$this->client->setValue(
			Argument::type('string'),
			Argument::exact('somevalue')
		)->shouldBeCalled();

		$this->report->set_report('somevalue');
	}
}
