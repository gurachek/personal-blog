<?php

use Slim\Views\PhpRenderer;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

include_once 'vendor/autoload.php';
include_once 'functions.php';

spl_autoload_register('autoloader');

function autoloader($className) {

	$array = explode("\\", $className);

	if ($array[1] != "PDO")
		require_once __DIR__ . '/' . $array[0] . '/' . $array[1] . '.php' ;
	else
		return false;
}


$container = [
	'settings' => [
		'displayErrorDetails' => true,
		'debug' => true,

		'db' => [

		],
	],
	'db' => function () {
		try {
			$db = new PDO('mysql:dbname=gurachek-blog;host=127.0.0.1', 'root', '');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->exec("SET NAMES utf8 COLLATE utf8_unicode_ci");
		} catch(Exception $e) {
			return $e->getMessage();
		} 

		return $db;
	},
	'url' => 'http://vie.blog/',
	'imgFolder' => 'web/images/',
	'postImages' => 'posts/',
	'userImages' => 'users/',
	'categoryImage' => 'categories/',
	'estimateTypeImage' => 'estimate_types/',
];

$user = new models\User();

$app = new \Slim\App($container);

$container = $app->getContainer();
$container['url'] = 'http://vie.blog/';
$container['template'] = 'layouts/main.php';
$container['renderer'] = new PhpRenderer("views");
$container['userObj'] = $user;
$container['user'] = $user->findUserByAuthKey(@$_COOKIE['auth']);

/*
	// Tasks:
	// 1. Return object instead of just id child table -- DONE!!
	// 2. Image uploading -- IN PROGRESS
	// |
	// |--o-- I should add image uploading to the next api endpoints: 
	// |--o-- post, user, category, estimate_type.   
	// |--o--
	// |--o--
*/	

// All App Interface 

include('api/post.php');
include('api/category.php');
include('api/user.php');
include('api/estimate.php');
include('api/estimate_type.php');
include('api/tag.php');
include('api/post_tag.php');

// Web routes

$app->get('/', function (Request $request, Response $response, array $args) use ($container) {

	$data = json_decode(@file_get_contents('http://vie.blog/api/v1/post'), true);

	return $this->renderer->render($response, $container['template'], [
		'content' => 'index',
		'data' => $data,
		'c' => $container
	]);

});

$app->get('/post/{id}', function (Request $request, Response $response, array $args) use ($container) {

	// Example of usage api (fetching singular post data)
	$data = json_decode(@file_get_contents('http://vie.blog/api/v1/post/'.$args['id']), true);

	return $this->renderer->render($response, $container['template'], [
		'content' => 'post',
		'data' => $data,
		'title' => $data['title'],
		'c' => $container,
	]);

});


$app->get('/signup', function (Request $request, Response $response, array $args) use ($container) {

	$title = 'Регистрация';

	if ($container->user)
		return $response->withRedirect($container->url);

	return $this->renderer->render($response, '/signup.php', [
		'title' => $title,
		'c' => $container,
	]);

});

$app->get('/signin', function (Request $request, Response $response, array $args) use ($container) {

	$title = 'Авторизация';

	if ($container->user)
		return $response->withRedirect($container->url);

	return $this->renderer->render($response, '/signin.php', [
		'title' => $title,
		'c' => $container,
	]);

}); 

$app->post('/signin', function (Request $request, Response $response, array $args) use ($container) {

	$data = $request->getParsedBody();

	unset($data['submit']);

	if (empty($data['email']) || empty($data['password'])) return false;

	$email = strip_tags($data['email']);

	$user = $container->userObj->getUserByEmail($email);

	$password = hash('sha256', $data['password']);

	if ($password === $user['password'])
		setcookie("auth", $user['auth_key'], time()+3600, "/", "", 0);;

	return $response->withRedirect($this->url);

});

$app->post('/logout', function (Request $request, Response $response, array $args) use ($container) {

	$data = $request->getParsedBody();

	if (!@$data['logout']) return false;

	if (!@$_COOKIE['auth']) return false;

	setcookie("auth", "", null, "/", "", 0);

	return $response->withRedirect($this->url);

});

$app->get('/about', function (Request $request, Response $response, array $args) use ($container) {

	$title = "О блоге";

	return $this->renderer->render($response, $container['template'], [
		'content' => 'about',
		'title' => $title,
		'c' => $container,
	]);

});

$app->get('/categories', function (Request $request, Response $response, array $args) use ($container) {

	$title = "Категории";

	$data = json_decode(@file_get_contents('http://vie.blog/api/v1/category'), true);

	return $this->renderer->render($response, $container['template'], [
		'content' => 'categories',
		'data' => $data,
		'title' => $title,
		'c' => $container,
	]);

});

$app->get('/category/{id}', function (Request $request, Response $response, array $args) use ($container) {

	$data = json_decode(@file_get_contents('http://vie.blog/api/v1/category/'. $args['id']), true); 

	$title = $data['name'];

	$posts = json_decode(@file_get_contents('http://vie.blog/api/v1/posts/category/'. $data['id']), true);

	return $this->renderer->render($response, $container['template'], [
		'content' => 'category',
		'data' => $data,
		'posts' => $posts,
		'title' => $title,
		'c' => $container,
	]);

});

$app->get('/user/{id}', function (Request $request, Response $response, array $args) use ($container) {

	$data = json_decode(@file_get_contents('http://vie.blog/api/v1/user/'. $args['id']), true); 

	$title = $data['name'];

	$posts = json_decode(@file_get_contents('http://vie.blog/api/v1/posts/user/'. $data['id']), true);

	return $this->renderer->render($response, '/user.php', [
		'data' => $data,
		'posts' => $posts,
		'title' => $title,
		'c' => $container,
	]);

});

$app->get('/tag/{id}', function (Request $request, Response $response, array $args) use ($container) {

	$id = (int) $args['id'];

	$posts = json_decode(@file_get_contents('http://vie.blog/api/v1/tag/'. $id .'/posts'), true);

	$tag = $posts['tag'];
	unset($posts['tag']);

	$title = $tag['name'];

	return $this->renderer->render($response, $container['template'], [
		'content' => 'tag',
		'posts' => $posts,
		'tag' => $tag,
		'posts' => $posts,
		'title' => $title,
		'c' => $container,
	]);

});

$app->run();