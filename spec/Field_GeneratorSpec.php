<?php

namespace spec\DSteiner23\Custom_Field_Repository;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Client\Client_Interface;
use DSteiner23\Custom_Field_Repository\Examples\Sales_Report;
use DSteiner23\Custom_Field_Repository\Field_Generator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Field_GeneratorSpec extends ObjectBehavior {
	function it_is_initializable() {
		$this->shouldHaveType( Field_Generator::class );
	}

	function let( Client_Interface $client ) {
		$this->beConstructedWith(
			[
				Sales_Report::class
			],
			$client,
			new Annotations() );
	}

	function it_generates_fields( $client ) {
		$client->create_field_group(
			Argument::exact( 'sales' ),
			Argument::any()
		)->shouldBeCalled();

		$client->create_field(
			Argument::exact( 'report' ),
			Argument::exact( 'sales' ),
			Argument::any() )
		       ->shouldBeCalled();

		$this->generate()->shouldBeArray();
	}
}
