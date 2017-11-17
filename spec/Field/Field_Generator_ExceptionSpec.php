<?php

namespace spec\DSteiner23\Custom_Field_Repository\Field;

use DSteiner23\Custom_Field_Repository\Field\Field_Generator_Exception;
use PhpSpec\ObjectBehavior;

class Field_Generator_ExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Field_Generator_Exception::class);
	    $this->shouldBeAnInstanceOf(\RuntimeException::class);
    }
}
