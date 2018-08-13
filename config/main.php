<?php

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
	'url' => 'http://localhost:8000/',
	'imgFolder' => 'web/images/',
	'postImages' => 'posts/',
	'userImages' => 'users/',
	'categoryImage' => 'categories/',
	'estimateTypeImage' => 'estimate_types/',
];