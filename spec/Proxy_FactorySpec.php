<?php

namespace spec\DSteiner23\Custom_Field_Repository;

use DSteiner23\Custom_Field_Repository\Lazy_Load_Ghost_Proxy;
use DSteiner23\Custom_Field_Repository\Provider\Provider_Manager;
use DSteiner23\Custom_Field_Repository\Proxy_Factory;
use PhpSpec\ObjectBehavior;
use Test\Fixtures\Annotation_Valid;

/**
 * @package spec\DSteiner23\Custom_Field_Repository
 */
class Proxy_FactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Proxy_Factory::class);
    }

    function it_should_create_lazy_load_ghost_proxy()
    {
    	$this::create(Annotation_Valid::class, 1)->shouldReturnAnInstanceOf(Lazy_Load_Ghost_Proxy::class);
    }

    //Todo: fixen
//    function it_should_throw_error_if_class_not_found()
//    {
//	    $this->shouldThrow(\Error::class)->during('create', [\stdClass::class, 1]);
//    }
}
