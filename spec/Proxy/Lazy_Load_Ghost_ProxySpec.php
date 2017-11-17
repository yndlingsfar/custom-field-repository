<?php

namespace spec\DSteiner23\Custom_Field_Repository\Proxy;

use Alchemy\Component\Annotations\Annotations;
use DSteiner23\Custom_Field_Repository\Proxy\Lazy_Load_Ghost_Proxy;
use DSteiner23\Custom_Field_Repository\Provider\Provider_Interface;
use PhpSpec\ObjectBehavior;
use Test\Fixtures\Annotation_Valid;

class Lazy_Load_Ghost_ProxySpec extends ObjectBehavior
{
    function let(Provider_Interface $provider, Annotations $annotations)
    {
	    $annotations->getClassAnnotations( Annotation_Valid::class )->willReturn(
		    [
			    'Field_Group' => [
				    0 => [
					    'name' => 'some_field_group',
					    'provider' => 'acf',
				    ]
			    ]
		    ]
	    );

	    $annotations->getPropertyAnnotations(Annotation_Valid::class, 'report')->willReturn(
		    [
			    'Field' => [
				    0 => [
					    'name' => 'report',
					    'type' => 'text',
				    ]
			    ]
		    ]
	    );

	    $class = new Annotation_Valid();
	    $class->set_report('the_report');

		$this->beConstructedWith($provider, $annotations, $class, 1);
		$this->add_change('some_property');
    }

	function it_is_initializable()
    {
        $this->shouldHaveType(Lazy_Load_Ghost_Proxy::class);
    }

    function it_should_check_if_property_changed()
    {
	    $this->add_change('report');
    	$this->is_changed('report')->shouldReturn(true);
    }

	function it_should_get_all_changes()
	{
		$this->get_changes()->shouldReturn(['some_property']);
	}

	function it_should_get_the_id()
	{
		$this->get_id()->shouldReturn(1);
	}

	function it_should_get_the_client()
	{
		$this->get_client()->shouldReturnAnInstanceOf(Provider_Interface::class);
	}

	function  it_should_get_the_property_name()
	{
		$this->get_property_path('report')->shouldReturn('some_field_group.report');
	}

	function it_should_get_the_property_value(Provider_Interface $provider)
	{
		$provider->get_value('some_field_group.report', 1)->shouldBeCalled()->willReturn('the_report');
		$this->get_property_value('report')->shouldReturn('the_report');
	}
}
