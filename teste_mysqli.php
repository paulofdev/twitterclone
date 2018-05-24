<?php
	
	require_once('db_class.php');

	$sql = "SELECT * FROM usuarios ";

	$objDb = new db();
	$link = $objDb->connMysql();

	$result_id = mysqli_query($link, $sql);

	if ($result_id) {
		$user_date = array();
	
		while ($linha = mysqli_fetch_array($result_id, MYSQLI_ASSOC))
		{
			$user_date[] = $linha; 
		}
		
		foreach ($user_date as $usuario) {
			var_dump($usuario['senha']);
			echo "<br><br>";
		}
	} else {

		echo "Usuario e/ou senha inválidos";

	}




?>