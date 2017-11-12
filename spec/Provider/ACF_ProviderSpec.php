<?php

namespace spec\DSteiner23\Custom_Field_Repository\Provider;

use DSteiner23\Custom_Field_Repository\Provider\ACF_Provider;
use DSteiner23\Custom_Field_Repository\Provider\Provider_Interface;
use PhpSpec\ObjectBehavior;

class ACF_ProviderSpec extends ObjectBehavior {
	function it_is_initializable() {
		$this->shouldHaveType( ACF_Provider::class );
		$this->shouldImplement( Provider_Interface::class );
	}

	//Todo: Specs mit WP nativen Funktionen?
}
