<?php 

session_start();

if(!isset($_SESSION['usuario'])){
	header('Location: index.php?erro=1');
}

require_once('db_class.php');

$nome_pessoa = $_POST['nome_pessoa'];
$id_usuario = $_SESSION['id_usuario'];

$objDB = new db();
$link = $objDB->connMysql();

$sql = "SELECT * FROM usuarios WHERE usuario like '%$nome_pessoa%' AND id <> $id_usuario";

$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {
	while ($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) {
		echo "<a href='' class='list-group-item'>";
			echo '<strong>'.$registro["usuario"].'</strong> <small> - '.$registro["email"].' </small>';
			echo '<p class="list-group-item-text pull-right">';
				echo '<button type="button" class="btn btn-success btn_seguir" data-id_usuario="'.$registro['id'].'" >Seguir</button>';
				echo '&nbsp&nbsp&nbsp&nbsp';
				echo '<button type="button" class="btn btn-danger btn_unfollow" data-id_usuario="'.$registro['id'].'" >Deixar de seguir</button>';
			echo '</p>'; 
			echo '<div class="clearfix"> </div> ';
		echo "</a>";
	}
} else {
	echo "Erro na consulta das pessoas";
}

?>