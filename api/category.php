<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api', function () use ($app) {
	$app->group('/v1', function () use ($app) {

		$app->get('/category', function (Request $request, Response $response, array $args) {

			$category = $this->db->query("SELECT * FROM category");

			// Need to return 'parent_id' object (it can be as infinity loop).

			$data = $category->fetchAll();

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->get('/category/{id}', function (Request $request, Response $response, array $args) {

			$id = (int) $args['id'];

			$category = $this->db->prepare("SELECT * FROM category WHERE id = :id");
			$category->execute([':id' => $id]);

			$data = $category->fetch();

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->post('/category', function (Request $request, Response $response, array $args) {

			$data = $request->getParsedBody();

			$query = insertData($data, 'category');

			try {
				
				$this->db->query($query);
				$response->getBody()->write(true);
			
			} catch(PDOException $ex) {
			
				$response->getBody()->write(false);
			
			}

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->put('/category/{id}', function (Request $request, Response $response, array $args) {

			$id = (int) $args['id'];

			$data = $request->getParsedBody();

			$query = updateData($id, $data, 'category');

			$this->db->query($query);

			$post = $this->db->query("SELECT * FROM category WHERE id = $id");

			$response->getBody()->write(json_encode($post->fetch()));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->delete('/category/{id}', function (Request $request, Response $response, array $args) {

			$id = $args['id'];

			$post = $this->db->prepare("DELETE FROM category WHERE id = :id");
			
			if ($post->execute([':id' => $id]))
				$response->getBody()->write(true);

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});
	
	});
});

?>