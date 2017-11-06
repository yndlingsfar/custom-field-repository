<?php

namespace Test;

use DSteiner23\Custom_Field_Repository\Examples\Sales_Report;
use DSteiner23\Custom_Field_Repository\Field_Group_Repository;
use DSteiner23\Custom_Field_Repository\Lazy_Load_Ghost_Proxy;
use PHPUnit\Framework\TestCase;

class Field_Group_RepositoryTest extends TestCase {

	public function test_find_field_group() {
		$repository = new Field_Group_Repository();

		$ghost = $repository->find(
			Sales_Report::class,
			1
		);

		self::assertInstanceOf(
			Lazy_Load_Ghost_Proxy::class,
			$ghost
		);
	}

	public function test_persist() {

	}
}
