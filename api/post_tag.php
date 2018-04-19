<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api', function () use ($app) {
	$app->group('/v1', function () use ($app) {

		$app->get('/post-tag/{post_id}', function (Request $request, Response $response, array $args) {

			$id = (int) $args['post_id'];

			$post_tag = $this->db->prepare("SELECT * FROM post_tag WHERE post_id = :id");
			$post_tag->execute([':id' => $id]);

			$data = $post_tag->fetchAll();

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->post('/post-tag', function (Request $request, Response $response, array $args) {

			$data = $request->getParsedBody();

			$query = insertData($data, 'post_tag');

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

		$app->put('/post-tag/{id}', function (Request $request, Response $response, array $args) {

			$id = (int) $args['id'];

			$data = $request->getParsedBody();

			$query = updateData($id, $data, 'post_tag');

			$this->db->query($query);

			$post_tag = $this->db->query("SELECT * FROM post_tag WHERE id = $id");

			$response->getBody()->write(json_encode($post_tag->fetch()));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->delete('/post-tag/{id}', function (Request $request, Response $response, array $args) {

			$id = $args['id'];

			$post_tag = $this->db->prepare("DELETE FROM post_tag WHERE id = :id");
			
			if ($post_tag->execute([':id' => $id]))
				$response->getBody()->write(true);

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

	});
});

?>