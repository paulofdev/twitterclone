<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once('db_class.php');

	$objDB = new db();
	$link = $objDB->connMysql();


	$id_usuario = $_SESSION['id_usuario'];

	$sql = "SELECT COUNT(*) AS qtd_tweets FROM tweet WHERE id_usuario = $id_usuario";


	$resultado_id = mysqli_query($link, $sql);

	$tweets = 0;

	if($resultado_id){
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$tweets = $registro['qtd_tweets'];
	} else {
		echo "erro";
	}

	$busca_seguidores = "SELECT count(seguindo_id_usuario) AS seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $id_usuario";

	$resultado_busca = mysqli_query($link, $busca_seguidores);

	$seguidores = 0;
	
	if($resultado_busca){
		$registro_seguidores = mysqli_fetch_array($resultado_busca, MYSQLI_ASSOC);
		$seguidores = $registro_seguidores['seguidores'];
	} else {
		echo "erro";
	}
?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">	
		$(document).ready(function(){
			$('#btn_procurar_pessoa').click(function(){

				if ($('#nome_pessoas').val().length > 0) {

					$.ajax({
						url: 'get_pessoas.php',
						method: 'post',
						data: $('#form_procurar_pessoas').serialize(),
						success: function(data) {
                            $('#pessoas').html(data);

							$('.btn_seguir').click(function() {
								var id_usuario = $(this).data('id_usuario');

								$('#btn_seguir_'+id_usuario).hide();
								$('#btn_nseguir_'+id_usuario).show();

								$.ajax({
									url: 'seguir.php',
									method: 'post',
									data: {seguir_id_usuario: id_usuario},
									success: function(data){
										console.log('seguindo');
									}
								});
							});//fim do follow
							
							$('.btn_unfollow').click(function(){
								var id_usuario = $(this).data('id_usuario');
								
								$('#btn_seguir_'+id_usuario).show();
								$('#btn_nseguir_'+id_usuario).hide();

								$.ajax({
									url: 'deixar_seguir.php',
									method: 'post',
									data: {unfollow: id_usuario},
									success: function(data){
										console.log("registro removido com sucesso");
									}
								});
							});// Fim do unfollow
							
						}
					});

				} 

			});
		});
		</script>
	
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
	          data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/icone_twitter.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="home.php">Home</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	    	
	    	<br /><br />

	    	<div class="col-md-3">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
						<h4><?=$_SESSION['usuario']?></h4>
						<hr>	
						<div class="col-md-6">
							Tweets
							<br> 
							<?=$tweets?>
						</div>
						<div class="col-md-6">
							Seguidores
							<br>	
							<?=$seguidores?>
						</div>
	    			</div>
	    		</div>
	    	</div>

	    	<div class="col-md-6">
	    		<div class="panel panel-default">
					<div class="panel-body">	

						<form method="post" id="form_procurar_pessoas" class="input-group" name="procurar_pessoa" action="javascript:void(0);">	
							<input type="text" class="form-control" 
							placeholder="Quem você está procurando?" maxlength="140" id="nome_pessoas" name="nome_pessoa" />   
							<span class="input-group-btn">
								<button class="btn btn-default" id="btn_procurar_pessoa" type="button">Buscar</button>
							</span>
						</form>

					</div>
    			</div>
    			<div id="pessoas" class="list-group">
    				
    			</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">	
						<div class="panel-body">
						</div>
				</div>
			</div>


		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>