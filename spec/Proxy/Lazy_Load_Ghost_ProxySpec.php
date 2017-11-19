<?php

namespace spec\DSteiner23\Custom_Field_Repository\Proxy;

use DSteiner23\Custom_Field_Repository\Field\Field_Reader;
use DSteiner23\Custom_Field_Repository\Proxy\Lazy_Load_Ghost_Proxy;
use DSteiner23\Custom_Field_Repository\Provider\Provider_Interface;
use DSteiner23\Custom_Field_Repository\Proxy\Proxy_Exception;
use PhpSpec\ObjectBehavior;
use Test\Fixtures\Annotation_Underscore;

class Lazy_Load_Ghost_ProxySpec extends ObjectBehavior
{
    function let(Provider_Interface $provider, Field_Reader $reader)
    {
	    $class = new Annotation_Underscore();
	    $reader->is_annotated_field('user_name')->willReturn(true);

		$this->beConstructedWith($provider, $reader, $class, 1);
    }

	function it_is_initializable()
    {
        $this->shouldHaveType(Lazy_Load_Ghost_Proxy::class);
    }

	function it_can_delegate_the_provider()
	{
		$this->get_provider()->shouldReturnAnInstanceOf(Provider_Interface::class);
	}

	function it_should_be_empty_on_initialization() {

	}

	function it_should_lazy_load_when_using_isset() {

	}

	function it_should_lazy_load_when_using_getter($provider, $reader) {
		$reader->get_field_key('user_name')->shouldBeCalled()->willReturn('report.user_name');
		$provider->get_value('report.user_name', 1)->shouldBeCalled()->willReturn('some_user');

		$this->get_property_value('user_name')->shouldReturn('some_user');
	}

	function it_should_lazy_load_when_using_public_property() {

	}

	function it_should_lazy_load_when_using_serialize() {

	}

	function it_can_handle_underscore_getter($provider, $reader) {
		$reader->get_field_key('user_name')->shouldBeCalled()->willReturn('report.user_name');
		$provider->get_value('report.user_name', 1)->shouldBeCalled()->willReturn('some_user');

		$this->get_user_name()->shouldReturn('some_user');
	}

	function it_can_handle_camel_case_getter($provider, $reader) {
//		$reader->get_field_key('user_name')->shouldBeCalled()->willReturn('report.user_name');
//		$provider->get_value('report.user_name', 1)->shouldBeCalled()->willReturn('some_user');
//
//		$this->getUserName()->shouldReturn('some_user');
	}

	function it_can_handle_underscore_setter() {

	}

	function it_can_handle_camel_case_setter() {

	}

	function it_should_delegate_any_function_call() {

	}

	function it_should_throw_exception_if_calling_unknown_method() {
		$this->shouldThrow(Proxy_Exception::class)->during('some_unknown_method');
	}

	function it_should_mark_a_property_changed_when_using_setter() {
    	//setter benutzen
//		$this->get_changes()->shouldReturn(['some_property']);
	}


//	function it_should_get_the_property_value(Provider_Interface $provider, $reader)
//	{
//		$reader->is_annotated_field( 'report' )->willReturn(true);
//		$reader->get_field_key( 'report' )->willReturn('some_field_group.report');
//
//		$provider->get_value('some_field_group.report', 1)->shouldBeCalled()->willReturn('the_report');
//
//		$this->get_property_value('report')->shouldReturn('the_report');
//	}

	function it_should_delegate_field_key_name($reader) {
		$reader->get_field_key( 'report' )->willReturn('some_field_group.report');

    	$this->get_field_key('report')->shouldReturn('some_field_group.report');
	}
}
