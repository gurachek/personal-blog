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
		
		$data = $this->getUser(['key' => 'email', 'value' => $email]);

		return $data ?? false; 
	}

	public function findUserByAuthKey($authKey)
	{
		if (!$authKey) return false;

		$data = $this->getUser(['key' => 'auth_key', 'value' => $authKey]);

		return $data ?? false;
	}

	public function getUserIdByAuth($authKey)
	{
		if (!$authKey) return false;

		$data = $this->getUser(['key' => 'auth_key', 'value' => $authKey]);

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