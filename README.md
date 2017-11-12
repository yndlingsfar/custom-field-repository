[![Build Status](https://travis-ci.org/dsteiner23/custom-field-repository.svg?branch=master)](https://travis-ci.org/dsteiner23/custom-field-repository)

# Loki CFR - Custom Field Repository

a custom Field repository that transforms Wordpress custom fields into an Object Relational Mapper (ORM)

Configuration of object behaviour is done via annotations

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites
PHP 5.6+

Installation of Advanced Custom Fields Pro Plugin is recommended, but not neccessary

### Installing

Install plugin like any other Wordpress plugin

### How to use it

The plugin maps objects with specific annotations to a set of custom fields. Configuration is done via annotation

```php
<?php

/**
 * @Field_Group(name="sales", title="Annual sales reports", provider="acf")
 */
class Sales_Report {

	/**
	 * @var string
	 * @Field(name="report", type="text")
	 */
	private $report;

	/**
	 * We need a valid getter for lazy loading
	 * @return string
	 */
	public function get_report() {
		return $this->report;
	}

	/**
	 * We need a valid setter for saving data
	 * @param $report
	 */
	public function set_report( $report ) {
		$this->report = $report;
	}
}
```
The plugin comes with support for two different custom field provider.

**Advanced Custom Fields Pro (recommended, but requires installed ACF Pro plugin)**

```php
@Field_Group(name="sales", title="Annual sales reports", provider="acf")
```
**Wordpress native (default, no further plugin required)**

```php
@Field_Group(name="sales", title="Annual sales reports", provider="native")
```
Registering annotated classes

After generating an annotated class we register the class(es) and let the plugin do all the work (generating fields, fieldgroups etc)

```php
include_once get_stylesheet_directory() . '/models/Sales_Report.php';

add_action( 'init', 'register' );
function register() {
	$repository = register_custom_field_repository([Sales_Report::class]);
}

```

**Writing**

```php
add_action( 'init', 'write' );
function write() {
	$repository = get_custom_field_repository();

	$user = $repository->find(Sales_Report::class, $post_id);

	$user->set_report('Some Report');

	$repository->persist($user);
}

```

**Reading (Lazy loaded)**

Data is fetched with lazy loading by using the getter methods

```php
add_action( 'init', 'read' );
function read() {
	$repository = get_custom_field_repository();

	$user = $repository->find(Sales_Report:class, $post_id);

	print $user->get_report();

}

```

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Roadmap

* Repository functions (findBy(), findAll(), findOneBy() etc)

## Authors

* **Daniel Steiner** - *Initial work* - [dsteiner23](https://github.com/dsteiner23)

## License

This project is licensed under the GNU GENERAL PUBLIC LICENSE - see the [LICENSE.md](LICENSE.md) file for details
