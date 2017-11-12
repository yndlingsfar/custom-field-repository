<?php

namespace spec\DSteiner23\Custom_Field_Repository;

use DSteiner23\Custom_Field_Repository\Field_Generator_Exception;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Field_Generator_ExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Field_Generator_Exception::class);
	    $this->shouldBeAnInstanceOf(\RuntimeException::class);
    }
}
