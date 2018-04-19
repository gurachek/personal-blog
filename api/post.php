<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api', function () use ($app) {
	$app->group('/v1', function () use ($app) {
	
		$app->get('/post', function (Request $request, Response $response, array $args) {

			$post = $this->db->query("SELECT * FROM post");

			$i = 0;

			foreach($post->fetchAll() as $singlePost) {
				
				$data[$i] = $singlePost;
				
				$data[$i]['user'] = getApiData($this->url, 'user', $data[$i]['user_id']);
				$data[$i]['category'] = getApiData($this->url, 'category', $data[$i]['category_id']);
			
				$data[$i]['tags'] = getApiData($this->url, 'post-tag', $data[$i]['id']);

				for ($j = 0; $j < count($data[$i]['tags']); $j++) {
			
					$data[$i]['tags'][$j]['tag'] = getApiData($this->url, 'tag', $data[$i]['tags'][$j]['tag_id']);
				
				}

				// Nobody should know user password!	
				unset($data[$i]['user']['password']);

				$i++;
			}

			if ($request->getQueryParam('web') == true)
			{
				echo '<pre>';
				print_r($data);
				echo '</pre>';

				return;
			} 

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->get('/posts/category/{id}', function (Request $request, Response $response, array $args) {

			$id = $args['id'];
			$data = [];

			$posts = $this->db->prepare("SELECT * FROM post WHERE category_id = :id");
			$posts->execute([':id' => $id]);

			$posts_id = array_column($posts->fetchAll(), 'id');

			foreach($posts_id as $id) {
				$post = json_decode(file_get_contents('http://vie.blog/api/v1/post/'. $id), true);

				$data[] = $post;
			}

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->get('/posts/user/{id}', function (Request $request, Response $response, array $args) {

			$id = $args['id'];
			$data = [];

			$posts = $this->db->prepare("SELECT * FROM post WHERE user_id = :id");
			$posts->execute([':id' => $id]);

			$posts_id = array_column($posts->fetchAll(), 'id');

			foreach($posts_id as $id) {
				$post = json_decode(file_get_contents('http://vie.blog/api/v1/post/'. $id), true);

				$data[] = $post;
			}

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->get('/post/{id}', function (Request $request, Response $response, array $args) {

			$id = $args['id'];

			$post = $this->db->prepare("SELECT * FROM post WHERE id = :id");
			$post->execute([':id' => $id]);

			$data = $post->fetch();
			
			// Return user, category and tags objects

			if ($data !== false) {

				$data['user'] = getApiData($this->url, 'user', $data['user_id']);
				$data['category'] = getApiData($this->url, 'category', $data['category_id']);
				$data['tags'] = getApiData($this->url, 'post-tag', $data['id']);

				for ($i = 0; $i < count($data['tags']); $i++) {
		
					$data['tags'][$i]['tag'] = getApiData($this->url, 'tag', $data['tags'][$i]['tag_id']);
				
				}

				// Nobody should know user password! 
				unset($data['user']['password']);
				
			}

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);
		});

		$app->post('/post', function (Request $request, Response $response, array $args) {
			$data = $request->getParsedBody();

			$query = insertData($data, 'post');
			
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

		$app->put('/post/{id}', function (Request $request, Response $response, array $args) {
			$id = (int) $args['id'];

			$data = $request->getParsedBody();

			$query = updateData($id, $data, 'user');

			$this->db->query($query);

			$post = $this->db->query("SELECT * FROM post WHERE id = $id");

			$response->getBody()->write(json_encode($post->fetch()));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);
		});

		$app->delete('/post/{id}', function (Request $request, Response $response, array $args) {
			$id = $args['id'];

			$post = $this->db->prepare("DELETE FROM post WHERE id = :id");
			
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
