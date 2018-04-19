<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api', function () use ($app) {
	$app->group('/v1', function () use ($app) {

		$app->get('/tag', function (Request $request, Response $response, array $args) {

			$tag = $this->db->query("SELECT * FROM tag");

			$data = $tag->fetchAll();

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->get('/tag/{id}', function (Request $request, Response $response, array $args) {

			$id = (int) $args['id'];

			$tag = $this->db->prepare("SELECT * FROM tag WHERE id = :id");
			$tag->execute([':id' => $id]);

			$data = $tag->fetch();

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->get('/tag/{id}/posts', function (Request $request, Response $response, array $args) {

			$id = (int) $args['id'];

			$tag = json_decode(file_get_contents('http://vie.blog/api/v1/tag/'. $id), true);

			$posts = $this->db->prepare("SELECT id FROM post WHERE id IN (SELECT post_id FROM post_tag WHERE tag_id = :tag_id)");
			$posts->execute([':tag_id' => $tag['id']]);

			$posts_id = array_column($posts->fetchAll(), 'id');


			foreach($posts_id as $post_id) {

				$post = json_decode(file_get_contents('http://vie.blog/api/v1/post/'. $post_id), true);

				$data[] = $post;

			}

			$data['tag'] = $tag;

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->post('/tag', function (Request $request, Response $response, array $args) {

			$data = $request->getParsedBody();

			$query = insertData($data, 'tag');

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

		$app->put('/tag/{id}', function (Request $request, Response $response, array $args) {

			$id = (int) $args['id'];

			$data = $request->getParsedBody();

			$query = updateData($id, $data, 'tag');

			$this->db->query($query);

			$tag = $this->db->query("SELECT * FROM tag WHERE id = $id");

			$response->getBody()->write(json_encode($tag->fetch()));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->delete('/tag/{id}', function (Request $request, Response $response, array $args) {

			$id = $args['id'];

			$tag = $this->db->prepare("DELETE FROM tag WHERE id = :id");
			
			if ($tag->execute([':id' => $id]))
				$response->getBody()->write(true);

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

	});
});

?>