<?php

namespace spec\DSteiner23\Custom_Field_Repository\Provider;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Provider\ACF_Provider;
use DSteiner23\Custom_Field_Repository\Provider\Native_Provider;
use DSteiner23\Custom_Field_Repository\Provider\Provider_Manager;
use PhpSpec\ObjectBehavior;

/**
 * @package spec\DSteiner23\Custom_Field_Repository\Provider
 */
class Provider_ManagerSpec extends ObjectBehavior {

	function let($annotations) {
		$annotations->beADoubleOf( Annotations::class );
		$annotations->getClassAnnotations( 'Some_Class' )->willReturn(
			[
				'Field_Group' => [
					0 => [
						'name' => 'some_field_group'
					]
				]
			]
		);

		$this->beConstructedWith( $annotations, 'Some_Class' );
	}

	function it_is_initializable(  ) {
		$this->shouldHaveType( Provider_Manager::class );
	}

	function it_should_return_native_provider_if_no_provider_annotation_given() {
		$this->getProvider()->shouldReturnAnInstanceOf(Native_Provider::class);

	}

	function it_should_return_native_provider_if_native_provider_annotation_given($annotations) {
		$annotations->getClassAnnotations( 'Some_Class' )->willReturn(
			[
				'Field_Group' => [
					0 => [
						'name' => 'some_field_group',
						'provider' => 'native',
					]
				]
			]
		);
		$this->getProvider()->shouldReturnAnInstanceOf(Native_Provider::class);

	}

	function it_should_return_acf_provider_if_acf_provider_annotation_given($annotations) {
		$annotations->getClassAnnotations( 'Some_Class' )->willReturn(
			[
				'Field_Group' => [
					0 => [
						'name' => 'some_field_group',
						'provider' => 'acf',
					]
				]
			]
		);
		$this->getProvider()->shouldReturnAnInstanceOf(ACF_Provider::class);
	}
}
