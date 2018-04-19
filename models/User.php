<?php 

namespace models;

use models\Model;

class User extends Model
{

	public function __construct()
	{
		parent::__construct();
	} 

	public function getUserByEmail($email)
	{
		if (!$email) return false;
		
		$user = $this->db->prepare("SELECT * FROM user WHERE email = :email");
		$user->execute([':email' => $email]);	
	
		$data = $user->fetch();

		return $data ?? false; 
	}

	public function findUserByAuthKey($authKey)
	{
		if (!$authKey) return false;

		$user = $this->db->prepare("SELECT * FROM user WHERE auth_key = :key");
		$user->execute([':key' => $authKey]);

		$data = $user->fetch();

		return $data ?? false;
	}

	public function getUserIdByAuth($authKey)
	{
		if (!$authKey) return false;

		$user = $this->db->prepare("SELECT id FROM user WHERE auth_key = :key");
		$user->execute([':key' => $authKey]);

		$data = $user->fetch();

		if ($data)
			return $data['id'];
		else 
			return false;
	}

	public function validateAuthKey($authKey)
	{
		
	}

	public function createAuthKey($user)
	{

	}
}