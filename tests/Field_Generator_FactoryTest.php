<?php

namespace Test;

use DSteiner23\Custom_Field_Repository\Examples\Sales_Report;
use DSteiner23\Custom_Field_Repository\Field_Generator;
use DSteiner23\Custom_Field_Repository\Field_Generator_Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class Field_Generator_Factory
 * @package Test
 */
class Field_Generator_FactoryTest extends TestCase
{
    public function test_create_field_generator()
    {
      $factory = Field_Generator_Factory::create(
      	[Sales_Report::class]
      );

       self::assertInstanceOf(
           Field_Generator::class,
	       $factory
       );
    }
}
