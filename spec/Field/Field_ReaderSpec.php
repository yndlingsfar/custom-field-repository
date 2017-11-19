<?php

namespace spec\DSteiner23\Custom_Field_Repository\Field;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Field\Field_Reader;
use DSteiner23\Custom_Field_Repository\Proxy\Proxy_Exception;
use PhpSpec\ObjectBehavior;

class Field_ReaderSpec extends ObjectBehavior {
	function let( Annotations $annotations ) {
		$annotations->getClassAnnotations( \stdClass::class )->willReturn(
			[
				'Field_Group' => [
					0 => [
						'name'     => 'some_field_group',
						'provider' => 'acf',
					]
				]
			]
		);

		$annotations->getPropertyAnnotations( \stdClass::class, 'some_property' )->willReturn(
			[
				'Field' => [
					0 => [
						'name' => 'some_field_name',
						'type' => 'text',
					]
				]
			]
		);

		$this->beConstructedWith( $annotations, \stdClass::class );
	}

	function it_is_initializable() {
		$this->shouldHaveType( Field_Reader::class );
	}

	function it_should_check_if_field_has_annotations() {
		$this->is_annotated_field( 'some_property' )->shouldReturn( true );
	}

	function it_should_get_a_field_name() {
		$this->get_field_name( 'some_property' )->shouldReturn( 'some_field_name' );
	}

	function it_should_throw_proxy_excpetion_for_missing_field_name( $annotations ) {
		$annotations->getPropertyAnnotations( \stdClass::class, 'unknown_property' )->willReturn(
			[
				'Field' => [
					0 => []
				]
			] );
		$this->shouldThrow( Proxy_Exception::class )->during( 'get_field_name', [ 'unknown_property' ] );
	}

	function it_should_get_the_field_group_name() {
		$this->get_field_group_name()->shouldReturn( 'some_field_group' );
	}

	function it_should_throw_proxy_excpetion_for_missing_field_group_name( $annotations ) {
		$annotations->getClassAnnotations( \stdClass::class )->willReturn(
			[
				'Field_Group' => [
					0 => []
				]
			] );
		$this->shouldThrow( Proxy_Exception::class )->during( 'get_field_group_name' );
	}

	function it_should_get_a_field_key() {
		$this->get_field_key('some_property')->shouldReturn('some_field_group.some_field_name');
	}
}
