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

		$this->client = $this->prophesize( Client_Interface::class );
	}

	public function test_generate_fields() {

		$this->client->create_field_group( Argument::exact( 'sales' ), Argument::any() )->shouldBeCalled();
		$this->client->create_field( Argument::exact( 'report' ), Argument::exact( 'sales' ) )->shouldBeCalled();

		$generator = new Field_Generator(
			[
				Sales_Report::class
			],
			$this->client->reveal(),
			new Annotations()
		);

		$generated = $generator->generate();
		self::assertCount( 1, $generated );
		self::assertInstanceOf( Sales_Report::class, $generated[0] );
	}

	/**
	 * @dataProvider additionalOptionsProvider
	 *
	 * @param $key
	 * @param $value
	 */
	public function test_additional_options_field_group( $key, $value ) {

		$this->client->create_field_group(
			Argument::exact( 'sales' ),
			Argument::withEntry( $key, $value )
		)->shouldBeCalled();

		$this->client->create_field(
			Argument::exact( 'report' ),
			Argument::exact( 'sales' )
		)->shouldBeCalled();

		$generator = new Field_Generator(
			[
				Sales_Report::class
			],
			$this->client->reveal(),
			new Annotations()
		);

		$generator->generate();
	}

	public function test_available_data_types() {
		// Hier die Datentypen testen
	}

	/**
	 * @return array
	 */
	public function additionalOptionsProvider() {
		return [
			[ 'title', 'Annual sales reports' ]
		];
	}
}
