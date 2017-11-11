<?php

namespace spec\DSteiner23\Custom_Field_Repository;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Client\Client_Interface;
use DSteiner23\Custom_Field_Repository\Field_Generator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Test\Fixtures\Annotation_Valid;

class Field_GeneratorSpec extends ObjectBehavior {
	function it_is_initializable() {
		$this->shouldHaveType( Field_Generator::class );
	}

	function let( Client_Interface $client, Annotations $annotations ) {

		$annotations->beADoubleOf( Annotations::class );

		$this->beConstructedWith(
			[
				Annotation_Valid::class
			],
			$client,
			$annotations );
	}

	function it_generates_fields( $client, $annotations ) {
		$annotations->getClassAnnotations( Annotation_Valid::class )->willReturn(
			[
				'Field_Group' => [
					0 => [
						'name'  => 'some_field_group',
						'title' => 'some title'
					]
				]
			]
		);

		$annotations->getAllPropertyAnnotations( Annotation_Valid::class )->willReturn(
			[
				0 => [
					'Field' => [
						0 => [
							'name' => 'some_name',
							'type' => 'text',
						]
					]
				]
			]
		);

		$client->create_field_group(
			Argument::exact( 'some_field_group' ),
			Argument::any()
		)->shouldBeCalled();

		$client->create_field(
			Argument::exact( 'some_name' ),
			Argument::exact( 'some_field_group' ),
			Argument::any() )
		       ->shouldBeCalled();

		$this->generate()->shouldBeArray();
	}
}
