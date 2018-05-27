<?php 	

session_start();

if(!isset($_SESSION['usuario'])){
	header('Location: index.php?erro=1');
}

require_once('db_class.php');

$id_usuario = $_SESSION['id_usuario'];
$unfollow = $_POST['unfollow'];

if ($id_usuario == '' || $unfollow == '') {
	die();
}

$objDB = new db();
$link = $objDB->connMysql();

$sql = "DELETE FROM usuarios_seguidores WHERE id_usuario = $id_usuario  AND seguindo_id_usuario = $unfollow "; 

mysqli_query($link, $sql);

?>