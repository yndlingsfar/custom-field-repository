<?php

namespace spec\DSteiner23\Custom_Field_Repository;

use DSteiner23\Custom_Field_Repository\Proxy_Exception;
use PhpSpec\ObjectBehavior;

/**
 * @package spec\DSteiner23\Custom_Field_Repository
 */
class Proxy_ExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Proxy_Exception::class);
        $this->shouldBeAnInstanceOf(\RuntimeException::class);
    }
}
