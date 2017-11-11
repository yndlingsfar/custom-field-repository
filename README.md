[![Build Status](https://travis-ci.org/dsteiner23/custom-field-repository.svg?branch=master)](https://travis-ci.org/dsteiner23/custom-field-repository)

# Loki CFR - Custom Field Repository

a custom Field repository that transforms Wordpress custom fields into an Object Relational Mapper (ORM)

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

You need to have **Advanced Custom Fields Pro** installed. In the next version there will be a provider for **Wordpress native Custom Fields API**

### Installing

A step by step series of examples that tell you have to get a development env running

End with an example of getting some data out of the system or using it for a little demo

### How to use it

Generate annotated objects

```php
<?php

/**
 * @Field_Group(name="sales", title="Annual sales reports")
 */
class Sales_Report {

	/**
	 * @var string
	 * @Field(name="report", type="text")
	 */
	private $report;

	/**
	 * @return string
	 */
	public function get_report() {
		return $this->report;
	}

	/**
	 * @param $report
	 */
	public function set_report( $report ) {
		$this->report = $report;
	}
}
```
Registering annotated classes

```php
include_once get_stylesheet_directory() . '/models/Sales_Report.php';

add_action( 'init', 'register' );
function register() {
	$repository = register_custom_field_repository([Sales_Report::class]);
}

```

## Running the tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```
## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Roadmap

* Provider for Wordpress native custom fields
* Repository functions (findBy(), findAll(), findOneBy() etc)

## Authors

* **Daniel Steiner** - *Initial work* - [dsteiner23](https://github.com/dsteiner23)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone who's code was used
* Inspiration
* etc

Annotation Reader erwähnen!!


include_once get_stylesheet_directory() . '/models/User.php';

add_action( 'init', 'register' );
function register() {
	$repository = register_custom_field_repository([User::class]);
}


add_action( 'init', 'read' );
function read() {
	$repository = get_custom_field_repository();

	$user = $repository->find(User::class, $post_id);

	print $user->get_user_name();

}

add_action( 'init', 'write' );
function write() {
	$repository = get_custom_field_repository();

	$user = $repository->find(User::class, $post_id);

	$user->set_user_name('My Name');

	$repository->persist($user);
}
