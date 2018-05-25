<?php

session_start();

require_once('db_class.php');

$user = $_POST['login'];
$pswrd = md5($_POST['password']);

$sql = "SELECT id, usuario, email FROM usuarios where usuario='$user' AND senha='$pswrd' ";

$objDb = new db();
$link = $objDb->connMysql();

$result_id = mysqli_query($link, $sql);

if ($result_id) {
	$user_date = mysqli_fetch_array($result_id);

	if (isset($user_date['usuario'])) {

		$_SESSION['id_usuario'] = $user_date['id'];
		$_SESSION['usuario'] = $user_date['usuario'];
		$_SESSION['email'] = $user_date['email'];


		header('Location: home.php');

	} else {

		header('Location: index.php?erro=1');

	}

} else {
	echo "Usuario e/ou senha inválidos";
}




?>