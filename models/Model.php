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
}