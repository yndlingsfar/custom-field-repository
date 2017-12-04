<?php

namespace spec\DSteiner23\Custom_Field_Repository\Proxy;

use DSteiner23\Custom_Field_Repository\Proxy\Proxy_Exception;
use DSteiner23\Custom_Field_Repository\Proxy\Proxy_Factory;
use PhpSpec\ObjectBehavior;
use ProxyManager\Proxy\GhostObjectInterface;
use Test\Fixtures\Annotation_Underscore;

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
    	$this::create(Annotation_Underscore::class, 1)->shouldReturnAnInstanceOf(GhostObjectInterface::class);
    }

    function it_detects_missing_id_field()
    {
    	$this->shouldThrow(Proxy_Exception::class)->during('create', [\stdClass::class, 1]);
    }
}
