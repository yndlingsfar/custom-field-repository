<?php

namespace Test;

use DSteiner23\Custom_Field_Repository\Examples\Sales_Report;
use DSteiner23\Custom_Field_Repository\Lazy_Load_Ghost_Proxy;
use DSteiner23\Custom_Field_Repository\Proxy_Factory;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class Proxy_FactoryTest extends TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $report;

    public function setUp()
    {
        parent::setUp();
        $this->report = $this->prophesize(
            Sales_Report::class
        );
    }

    public function testCreateGhostObject()
    {
       $ghost = Proxy_Factory::create(
           $this->report->reveal(),
           1
       );

       self::assertInstanceOf(
           Lazy_Load_Ghost_Proxy::class,
           $ghost
       );
    }
}
