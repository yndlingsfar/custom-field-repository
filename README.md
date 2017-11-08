[![Build Status](https://travis-ci.org/dsteiner23/custom-field-repository.svg?branch=master)](https://travis-ci.org/dsteiner23/custom-field-repository)

# LOKI CFR

a custom Field repository that transforms WP custom fields into an Object Relational Mapper (ORM)


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
