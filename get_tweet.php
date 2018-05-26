<?php 

session_start();

if(!isset($_SESSION['usuario'])){
	header('Location: index.php?erro=1');
}

require_once('db_class.php');

$id_usuario = $_SESSION['id_usuario'];

$objDB = new db();
$link = $objDB->connMysql();

$sql = "SELECT * FROM tweet WHERE id_usuario = $id_usuario ORDER BY data_inclusao DESC";

// echo $sql;

$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {
	while ($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) {
			var_dump($registro);
		 echo "<br><br>";
	}
} else {
	echo "Erro na consulta dos tweets";
}

?>