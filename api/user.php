<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile;

$app->group('/api', function () use ($app) {
	$app->group('/v1', function () use ($app) {

		$app->get('/user', function (Request $request, Response $response, array $args) {
				
			$user = $this->db->query("SELECT * FROM user ORDER BY created");

			$data = $user->fetchAll();

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});
	
		$app->get('/user/{id}', function (Request $request, Response $response, array $args) {
			
			$id = (int) $args['id'];

			$user = $this->db->prepare("SELECT * FROM user WHERE id = :id");
			$user->execute([':id' => $id]);

			$data = $user->fetch();

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->post('/user', function (Request $request, Response $response, array $args) {

			$data = $request->getParsedBody();

			if (empty($data['name']) || empty($data['email']) || empty($data['password']))
				return 0;

			unset($data['submit']);

			$data['password'] = hash('sha256', $data['password']);
			$data['auth_key'] = hash('sha256', ($data['email'] . time()));
			$data['active'] = 1;

			$directory = __DIR__ .'/../'. $this->imgFolder . $this->userImages;

			$image = $request->getUploadedFiles()['image'];

			if ($image->getError() === UPLOAD_ERR_OK) {
				$filename = moveUploadedFile($directory, $image);

				$data['image'] = $filename;
			} else {
				$data['image'] = 'default.jpg';
			}

			$query = insertData($data, 'user');

			try {
				
				$this->db->query($query);
				// $response->getBody()->write(true);
			
			} catch(PDOException $ex) {
			
				// $response->getBody()->write(false);
			
			}

			setcookie("auth", $data['auth_key'], time()+3600, "/", "", 0);
			return $response->withRedirect($this->url);

			// return $response->withHeader(
			// 	'Content-Type',
			// 	'application/json'
			// );

		});

		$app->put('/user/{id}', function (Request $request, Response $response, array $args) {

			$id = (int) $args['id'];

			$data = $request->getParsedBody();

			$query = updateData($id, $data, 'user');

			$this->db->query($query);

			$post = $this->db->query("SELECT * FROM user WHERE id = $id");

			$response->getBody()->write(json_encode($post->fetch()));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->delete('/user/{id}', function (Request $request, Response $response, array $args) {

			$id = $args['id'];

			$post = $this->db->prepare("DELETE FROM user WHERE id = :id");
			
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