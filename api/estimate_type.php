<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('/api', function () use ($app) {
	$app->group('/v1', function () use ($app) {

		$app->get('/estimate-type', function (Request $request, Response $response, array $args) {

			$estimateType = $this->db->query("SELECT * FROM estimate_type");

			$data = $estimateType->fetchAll();

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->get('/estimate-type/{id}', function (Request $request, Response $response, array $args) {

			$id = (int) $args['id'];

			$estimateType = $this->db->prepare("SELECT * FROM estimate_type WHERE id = :id");
			$estimateType->execute([':id' => $id]);

			$data = $estimateType->fetch();

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->post('/estimate-type', function (Request $request, Response $response, array $args) {

			$data = $request->getParsedBody();

			$query = insertData($data, 'estimate_type');

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

		$app->put('/estimate-type/{id}', function (Request $request, Response $response, array $args) {

			$id = (int) $args['id'];

			$data = $request->getParsedBody();

			$query = updateData($id, $data, 'estimate_type');

			$this->db->query($query);

			$estimateType = $this->db->query("SELECT * FROM estimate_type WHERE id = $id");

			$response->getBody()->write(json_encode($estimateType->fetch()));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->delete('/estimate-type/{id}', function (Request $request, Response $response, array $args) {

			$id = $args['id'];

			$estimateType = $this->db->prepare("DELETE FROM estimate_type WHERE id = :id");
			
			if ($estimateType->execute([':id' => $id]))
				$response->getBody()->write(true);

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

	});
});

?>