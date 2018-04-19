<?php

	function insertData($data, $table) 
	{
		$keys = array_keys($data);
		$values = array_values($data);

		$keyString = '';
		$valueString = '';

		for ($i = 0; $i < count($data); $i++) {
			$coma = '';

			if ($i != 0) $coma = ','; 

			$keyString .= $coma . '`'. $keys[$i] .'`';
			$valueString .= $coma . "'". $values[$i] ."'";
			
		}

		$query = "INSERT INTO $table($keyString) VALUES($valueString)";

		return $query;
	}

	function updateData($id, $data, $table)
	{
		$keys = array_keys($data);
		$values = array_values($data);

		$query = '';

		for ($i = 0; $i < count($data); $i++) {
			$coma = '';

			if ($i+1 != count($data)) $coma = ','; 

			$query .= $keys[$i] .' = "'. $values[$i] .'"'. $coma .' ';

		}

		$query = "UPDATE $table SET $query WHERE id = $id";

		return $query;
	}

	function getApiData($url, $route, $id = null)
	{
		$string = $url .'api/v1/'. $route .'/'. $id;

		$data = file_get_contents($string);

		return json_decode($data, true);
	}
	
	function moveUploadedFile($directory, $uploadedFile)
	{
	    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
	    $basename = time();
	    $filename = sprintf('%s.%0.8s', $basename, $extension);

	    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

	    return $filename;
	}
?>