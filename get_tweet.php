<?php 

session_start();

if(!isset($_SESSION['usuario'])){
	header('Location: index.php?erro=1');
}

require_once('db_class.php');

$id_usuario = $_SESSION['id_usuario'];

$objDB = new db();
$link = $objDB->connMysql();

$sql = "SELECT  DATE_FORMAT(t.data_inclusao, '%d %m %Y %T') AS dt_inclusao, t.tweet, u.usuario FROM tweet AS t JOIN usuarios AS u ON(t.id_usuario = u.id) WHERE id_usuario = $id_usuario ORDER BY data_inclusao DESC";



$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {
	while ($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) {
		echo '<a href="#" class="list-group-item">';
			echo '<h4 class="list-group-item-heading">'.$registro['usuario'].'
			<small> - '.$registro['dt_inclusao'].' </small></h4>';
			echo '<p class="list-grou-item-text">'.$registro['tweet'].'</p>';
		echo '</a>';
	}
} else {
	echo "Erro na consulta dos tweets";
}

?>