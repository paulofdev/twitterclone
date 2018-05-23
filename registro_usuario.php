<?php 

	require_once('db_class.php');
	
	$usr = $_POST['usuario'];
	$mail = $_POST['email'];
	$pw = $_POST['senha'];


	$objDb = new db();
	$link = $objDb->connMysql();

	 $sql = "INSERT INTO usuarios (usuario, email, senha) VALUES ('$usr', '$mail', '$pw')";

	 if (mysqli_query($link, $sql)) {
 		echo "Usuário cadastrado com sucesso";
	 } else {
	 	echo "erro ao cadastrar usuário";	
	 }

?>
