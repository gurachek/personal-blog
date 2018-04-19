<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// There are we can get all estimates and estimates to particular post or user.

$app->group('/api', function () use ($app) {
	$app->group('/v1', function () use ($app) {

		$app->get('/estimate', function (Request $request, Response $response, array $args) {
			
			$data = [];

			$estimate = $this->db->query("SELECT * FROM estimate ORDER BY time");

			$i = 0;

			foreach ($estimate->fetchAll() as $singleEstimate) {
				$data[$i] = $singleEstimate;

				$data[$i]['estimate_type'] = getApiData($this->url, 'estimate-type', $data[$i]['estimate_id']);

				$i++;
			}

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->get('/estimate/{table}/{id}', function (Request $request, Response $response, array $args) {
			
			$id = (int) $args['id'];

			// Values: user, post
			$table = $args['table'];
			$table_column = $table. '_id';

			$estimate = $this->db->prepare("SELECT * FROM estimate WHERE $table_column = :id");
			$estimate->execute([':id' => $id]);

			$data = [];

			$i = 0;

			if ($estimates = $estimate->fetchAll()) {

				foreach ($estimates as $singleEstimate) {
					
					$data[$i] = $singleEstimate;
				
					$data[$i]['estimate_type'] = getApiData($this->url, "estimate-type", $data[$i]['estimate_id']);

					$i++;
				}

			}

			$response->getBody()->write(json_encode($data));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->post('/estimate', function (Request $request, Response $response, array $args) {
			$data = $request->getParsedBody();

			$query = insertData($data, 'estimate');

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

		$app->put('/estimate/{id}', function (Request $request, Response $response, array $args) {

			$id = (int) $args['id'];

			$data = $request->getParsedBody();

			$query = updateData($id, $data, 'estimate');

			$this->db->query($query);

			$estimate = $this->db->query("SELECT * FROM estimate WHERE id = $id");

			$response->getBody()->write(json_encode($estimate->fetch()));

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);

		});

		$app->delete('/estimate/{id}', function (Request $request, Response $response, array $args) {
			$id = $args['id'];

			$estimate = $this->db->prepare("DELETE FROM estimate WHERE id = :id");
			
			if ($estimate->execute([':id' => $id]))
				$response->getBody()->write(true);

			return $response->withHeader(
				'Content-Type',
				'application/json'
			);
		
		});

	});
});

?>