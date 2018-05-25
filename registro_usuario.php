<?php

	require_once('db_class.php');

	$usr = $_POST['usuario'];
	$mail = $_POST['email'];
	$pw = md5($_POST['senha']);


	$objDb = new db();
	$link = $objDb->connMysql();

	$user_exists = false;
	$email_exists = false;

	$sql_user_search = "SELECT * FROM usuarios WHERE usuario ='$usr'";

	if ($result_id = mysqli_query($link, $sql_user_search)) {

		$user_date = mysqli_fetch_array($result_id, MYSQLI_ASSOC);

		if (isset($user_date['usuario'])) {
				$user_exists = true;
		}

	} else {

			echo "Erro ao tentar";

	}

	$sql_email_search = "SELECT * FROM usuarios WHERE email='$mail' ";

	if ($result_mail_id = mysqli_query($link, $sql_email_search)) {

				$user_mail = mysqli_fetch_array($result_mail_id, MYSQLI_ASSOC);

				if (isset($user_mail['email'])) {
						$email_exists = true;
				}

	}

	if ($user_exists || $email_exists) {
		$get_return = '';

		if($user_exists){
			 $get_return.="erro_usuario=1&";
		}
		if($email_exists){
			 $get_return.="erro_email=1&";
		}

		header('Location: inscrevase.php?'.$get_return);

		die();
	}

 	$sql = "INSERT INTO usuarios (usuario, email, senha) VALUES ('$usr', '$mail', '$pw')";

 	if (mysqli_query($link, $sql)) {

		echo "Usuário cadastrado com sucesso";

 	} else {

	 	echo "erro ao cadastrar usuário";

	}

?>
