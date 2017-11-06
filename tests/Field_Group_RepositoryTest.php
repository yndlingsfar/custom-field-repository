<?php

namespace Test;

use DSteiner23\Custom_Field_Repository\Client\Client_Interface;
use DSteiner23\Custom_Field_Repository\Examples\Sales_Report;
use DSteiner23\Custom_Field_Repository\Field_Group_Repository;
use DSteiner23\Custom_Field_Repository\Lazy_Load_Ghost_Proxy;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class Field_Group_RepositoryTest extends TestCase {

	/**
	 * @var ObjectProphecy
	 */
	private $proxy;

	/**
	 * @var ObjectProphecy
	 */
	private $client;

	public function setUp() {
		parent::setUp();

		$this->proxy = $this->prophesize(Lazy_Load_Ghost_Proxy::class);
		$this->client = $this->prophesize(Client_Interface::class);
	}

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

	/**
	 * @dataProvider persistProvider
	 *
	 * @param $changes
	 */
	public function test_persist($changes) {

		$this->proxy->get_client()->willReturn($this->client);
		$this->proxy->get_changes()->willReturn($changes);


		foreach ($changes as $change) {

			$this->proxy->get_property_value($change)->shouldBeCalled();
			$this->proxy->get_property_path($change)->shouldBeCalled();
			$this->proxy->get_id()->shouldBeCalled();

			$this->client->set_value(
				Argument::any(),
				Argument::any(),
				Argument::any()
			)->shouldBeCalled();
		}

		$repository = new Field_Group_Repository();

		$repository->persist(
			$this->proxy->reveal()
		);
	}

	/**
	 * @return array
	 */
	public function persistProvider() {
		return [
			[['report', 'author']],
			[['author']]
		];
	}
}
