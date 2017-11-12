<?php

namespace spec\DSteiner23\Custom_Field_Repository\Provider;

use DSteiner23\Custom_Field_Repository\Provider\Native_Provider;
use DSteiner23\Custom_Field_Repository\Provider\Provider_Interface;
use PhpSpec\ObjectBehavior;

class Native_ProviderSpec extends ObjectBehavior {
	function it_is_initializable() {
		$this->shouldHaveType( Native_Provider::class );
		$this->shouldImplement( Provider_Interface::class );
	}
}
