<?php

namespace models;

use PDO;

abstract class Model
{
	protected $db;

	protected function __construct()
	{
		$this->db = new PDO('mysql:dbname=gurachek-blog;host=127.0.0.1', 'root', '');
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} 

	protected function getUser(array $data)
	{
		if (!$data) return false;
		if (!$data['key'] || !$data['value']) return false; 

		$user = $this->db->prepare("SELECT * FROM user WHERE `". $data['key'] ."` = :value");
		$user->execute(['value' => $data['value']]); 

		return $user->fetch() ?? false;
	}
}