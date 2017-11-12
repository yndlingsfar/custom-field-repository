<?php

namespace spec\DSteiner23\Custom_Field_Repository;

use DSteiner23\Custom_Field_Repository\Examples\Sales_Report;
use DSteiner23\Custom_Field_Repository\Field_Generator;
use DSteiner23\Custom_Field_Repository\Field_Generator_Factory;
use PhpSpec\ObjectBehavior;

/**
 * @package spec\DSteiner23\Custom_Field_Repository
 */
class Field_Generator_FactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Field_Generator_Factory::class);
    }

    function it_creates_field_generator_instance() {
    	$this::create(
		   [
			   Sales_Report::class
		   ]
	    )->shouldReturnAnInstanceOf(Field_Generator::class);
    }
}
