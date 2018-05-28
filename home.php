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
			$('#btn_tweet').click(function(){

				if ($('#texto_tweet').val().length > 0) {

					$.ajax({
						url: 'inclui_tweet.php',
						method: 'post',
						data: $('#form_tweet').serialize(),
						success: function(data) {
							$('#texto_tweet').val('');
							atualizaTweet();
						}
					});

				} 

			});

			function atualizaTweet(){
				$.ajax({
					url:'get_tweet.php',
					success: function(data){
						$('#tweets').html(data);
					}
				});
			}
			atualizaTweet();
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
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$_SESSION['usuario']?><span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#" onclick="alert('Página em construção')">Meus dados</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="sair.php">Sair</a></li>
						</ul>
					</li>
				</ul>
	        </div>
	      </div>
	    </nav>
		<!-- <div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href=""> </a></li>
					
				</ul>
	        </div> -->


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
							<?= $tweets ?>
						</div>
						<div class="col-md-6">
							Seguidores
							<br>	
							<?= $seguidores ?>
						</div>
	    			</div>
	    		</div>
	    	</div>

	    	<div class="col-md-6">
	    		<div class="panel panel-default">
					<div class="panel-body">	
						<form method="post" id="form_tweet" class="input-group" name="texto_tweet">	
							<input type="text" class="form-control" 
							placeholder="O que está acontecendo agora?" maxlength="140" id="texto_tweet" name="texto_tweet" />   
							<span class="input-group-btn">
								<button class="btn btn-default" id="btn_tweet" type="button">Tweet</button>
							</span>
						</form>
					</div>
    			</div>
    			<div id="tweets" class="list-group">
    				
    			</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">	
						<div class="panel-body">	
								<h4><a href="procurar_pessoas.php">Procurar por pessoas</a></h4>
						</div>
				</div>
			</div>


		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>