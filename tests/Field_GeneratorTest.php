<?php
namespace Test;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Client\Client_Interface;
use DSteiner23\Custom_Field_Repository\Examples\Sales_Report;
use DSteiner23\Custom_Field_Repository\Field_Generator;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class Field_GeneratorTest extends TestCase {

	/**
	 * @var ObjectProphecy
	 */
	private $client;

	public function setUp() {
		parent::setUp();

		$this->client = $this->prophesize(Client_Interface::class);
	}

//	public function test_directory_not_found() {
//
//		self::expectException(\UnexpectedValueException::class);
//
//		new Field_Generator(
//			[
//				Sales_Report::class
//			],
//			$this->client->reveal()
//		);
//	}

	public function test_find_classes_with_interface() {

		$this->client->create_field_group(Argument::exact('sales'))->shouldBeCalled();
		$this->client->create_field(Argument::exact('report'), Argument::exact('sales'))->shouldBeCalled();

		$generator = new Field_Generator(
			[
				Sales_Report::class
			],
			$this->client->reveal(),
			new Annotations()
		);

		$generated = $generator->generate();
		self::assertCount(1, $generated);
		self::assertInstanceOf(Sales_Report::class, $generated[0]);
	}
}
