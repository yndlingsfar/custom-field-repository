<?php

namespace spec\DSteiner23\Custom_Field_Repository;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Provider\Provider_Interface;
use DSteiner23\Custom_Field_Repository\Field_Generator;
use DSteiner23\Custom_Field_Repository\Field_Generator_Exception;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Test\Fixtures\Annotation_Valid;

/**
 * @package spec\DSteiner23\Custom_Field_Repository
 */
class Field_GeneratorSpec extends ObjectBehavior {
	function it_is_initializable() {
		$this->shouldHaveType( Field_Generator::class );
	}

	function let( Provider_Interface $client, Annotations $annotations ) {

		$annotations->beADoubleOf( Annotations::class );

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

		$this->beConstructedWith(
			[
				Annotation_Valid::class
			],
			$client,
			$annotations );
	}

	function it_should_generate_fields( $client, $annotations ) {
		$annotations->getAllPropertyAnnotations( Annotation_Valid::class )->willReturn(
			[
				0 => [
					'Field' => [
						0 => [
							'name' => 'some_name'
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
			[] )
		       ->shouldBeCalled();

		$this->generate()->shouldBeArray();
	}

	function it_should_delegate_options_to_client( $annotations, $client ) {
		$annotations->getAllPropertyAnnotations( Annotation_Valid::class )->willReturn(
			[
				0 => [
					'Field' => [
						0 => [
							'name'    => 'some_name',
							'default' => '',
							'type'    => 'text',
						]
					]
				]
			]
		);

		$client->create_field_group(
			Argument::exact( 'some_field_group' ),
			[
				'title' => 'some title'
			]
		)->shouldBeCalled();

		$client->create_field(
			Argument::exact( 'some_name' ),
			Argument::exact( 'some_field_group' ),
			[
				'default' => '',
				'type'    => 'text'
			] )
		       ->shouldBeCalled();

		$this->generate()->shouldBeArray();
	}

	function it_should_throw_exception_if_field_options_is_unknwon($annotations, $client) {

		$annotations->getAllPropertyAnnotations( Annotation_Valid::class )->willReturn(
			[
				0 => [
					'Field' => [
						0 => [
							'name'    => 'some_name',
							'default' => '',
							'column'    => 'unknown',
						]
					]
				]
			]
		);

		$client->create_field_group(
			Argument::any(),
			Argument::any()
		)->shouldBeCalled();

		$this->shouldThrow(Field_Generator_Exception::class)->during('generate');

	}

	function it_should_throw_exception_if_field_group_name_is_missing($annotations) {
		$annotations->getClassAnnotations( Annotation_Valid::class )->willReturn(
			[
				'Field_Group' => [
					0 => [
						'title' => 'some title'
					]
				]
			]
		);


		$this->shouldThrow(Field_Generator_Exception::class)->during('generate');

	}

	function it_should_throw_exception_if_field_name_is_missing($annotations, $client) {
		$annotations->getAllPropertyAnnotations( Annotation_Valid::class )->willReturn(
			[
				0 => [
					'Field' => [
						0 => [
							'default' => ''
						]
					]
				]
			]
		);

		$client->create_field_group(
			Argument::any(),
			Argument::any()
		)->shouldBeCalled();

		$this->shouldThrow(Field_Generator_Exception::class)->during('generate');

	}
}
