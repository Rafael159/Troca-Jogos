<?php
	function __autoload($classe){
        require('classes/'.$classe.'.class.php');
    }
    @BD::conn();//conexão com o banco de dados	
    
    $jogos = new Jogos(); //chama a classe Jogos
    $console = new Consoles(); //chama a classe Consoles 
    $user = new Usuarios();      
    $genero = new Generos();
    $friend = new Friendships();

    /*recupera o ID do usuário*/
    $codUser = (isset($_GET['codigo']) && ($_GET['codigo'] != '') ? $_GET['codigo'] : '');
	$user->setIdUser($codUser);
	$dados = $user->findRegister();//dados do user da página

    /*se o ID não tiver setado, redireciona*/
    if(!$dados):
    	header("location:index.php");
    	exit;
	endif;
	$codUser = $dados->id_user;
	$idOn = Usuarios::getUsuario('id_user');//user logado
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Troque seus jogos antigos por jogos que ainda não teve"/>
		<meta name="description" content="Troque jogos - divirta-se sem gastar mais"/>
		<meta name="description" content="Perfil do usuário do Troca Jogos"/>
		<meta name="keywords" content="Troca,Jogo, jogos, Games,Jogadores"/>
		
		<title>RG - <?php echo " $dados->nomeUser"; ?></title>

		<link rel="stylesheet" type="text/css" href="css/fonts.css"/>
		<link rel="stylesheet" href="css/style-feed.css"/>		
		<link rel="stylesheet" type="text/css" href="css/header.css"/>
		<link rel="stylesheet" type="text/css" href="css/style-footer.css"/>

		<!--CSS BOOTSTRAP-->
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.css"/>

		<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	</head>
<body>
	<div class="container-fluid nopadding">
		<?php require 'require/header.php'; ?>
		
		<div id="main-content" role="main">
			<div class="row nopadding">
				<div class="col-lg-7 nopadding col-lg-push-1">
					<div class="prf-content">
						<div class="prf-top">
							<!--<img src="imagens/icones/profile.png" alt="Perfil" class="img-responsive" id="prf-img"/>-->
						</div>
						<div class="prf-down">							
							<div class="box-infos">
								<span class="user-info" id="user-name"><?php echo (isset($dados->nomeUser)) ? $dados->nomeUser : ''; ?></span>
								<span class="user-info" id="user-address"><?php echo (isset($dados->cidade) && ($dados->cidade!='') ? $dados->cidade : 'Não informado') ?> <?php echo (isset($dados->estado) && ($dados->estado!='') ? ' / '.$dados->estado : '') ?></span>
								<?php if(Usuarios::getUsuario('id_user') != $codUser): ?>
									<button class="btn <?php echo (isset($_SESSION['emailTJ'])) ? 'auth-message' : 'access-login' ?>" id="send-msg">Enviar mensagem</button>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 nopadding col-lg-push-1">
					<?php if($idOn): ?>
						<div class="friend-box">							
							<?php
								$row = Friendships::getFriendsHelper(array('who_sent'=>$idOn, 'who_accepted'=>$codUser));
								if($row):	
									$row = ($row[0]) ? $row[0] : $row;
									if($row->status == "Pendente"):
							?>
								<div class="alert alert-success" style="margin-left:15px; width:100%; text-align: center; ">Convite já enviado. Aguarde </div>	
							<?php else: ?>
								<span class="friend-title">Amigo adicionado <i class="fa fa-user-plus fa-1x" aria-hidden="true"></i></span>
								
							<?php endif; ?>
							<?php else: ?>
								<input type="hidden" id="coduser" value="<?php echo $codUser?>">
								<input type="hidden" id="idon" value="<?php echo $idOn?>">
								<span class="friend-title">Adicionar aos amigos <button class="btn btn-success" id="invite"><i class="fa fa-user-plus fa-1x" aria-hidden="true"></i></button></span>
							<?php endif; ?>
						</div>
						<div class="alert" id="alerta-msg"></div>
					<?php endif; ?>
					<div class="favorite-box">
						<?php						
							$cnsl = $console->consoleById($dados->console);
							foreach ($cnsl as $conso) {
								$vdfavorito = $conso->nome_console;
							}
						?>
						<span class="favorite-title">Console favorito</span>
						<span class="favorite-content"><?php  echo strtoupper((isset($vdfavorito)) ? $vdfavorito : 'Nenhum'); ?></span>						
					</div>					
				</div>
			</div><!-- / .row (1)-->
			<div class="row nopadding">
				<div class="col-lg-7 nopadding col-lg-push-1">
					<div class="box-game">
						<?php
							$jogos->setIdGamer($codUser);
							$arrayJogos = $jogos->listaJogoByUser();
							$qnt = $jogos->contaJogoById();
							if($qnt==0):
						?>
						<label class="bg-title">Nenhum jogo encontrado</label>
						<?php else: ?>
						<label class="bg-title">Jogos encontrados (<?php echo $qnt?>)</label>
							<?php								
								foreach ($arrayJogos as $key => $valor):								
							?>
							<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
								<div class="each-game">
									<a href="game/game.php?codigo=<?php echo $valor->id ?>">
										<img src="game/imagens/<?php echo str_replace(' ', '', strtolower($valor->nome_console))?>/<?php echo $valor->imagem?>" alt="Nome jogo" class="img-responsive"/>
										<span class="infogame"><?php echo strtoupper($valor->nome_console)?></span>
										<span class="infogame"><?php echo substr(strtoupper($valor->n_jogo),0,15).'...'?></span>
									</a>
								</div>
							</div>
						<?php endforeach;						
							endif; ?>				
					</div>
				</div>
			</div><!-- / .row (2)-->
		</div><!-- / #main-content-->
		<?php 
			if(isset($_SESSION['emailTJ']) AND Usuarios::getUsuario('id_user') != $codUser):
		?>
		<div class="chat">
			<div class="chat-title">Mensagem</div>
			<div class="chat-content">				
				<div class="mensagens" id="jan_<?php echo $valor->id_user;?>"> 
					<div class="blank_message">Nenhuma mensagem</div>
				</div>
				<input type="text" name="msg" placeholder="Digite sua mensagem" id="field-message" autocomplete="off"/>
			</div>
		</div>
		<?php endif; ?>
		<?php require 'footer.php'; ?>
	</div><!-- / .container-fluid-->
	
	<!--CHAMADA JAVASCRIPT-->
	<script type="text/javascript" src="js/jquery.js"></script><!--chama o arquivo principal do jquery-->
	<script>
		$(document).ready(function(){			
			playerON = '<?php echo Usuarios::getUsuario('id_user'); ?>';
		});
	</script>
	<!--JS BOOTSTRAP-->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/global.js"></script>
	<script src="js/funcoes.js"></script>
	<script src="js/events.js"></script>
	<script src="js/events-feed.js"></script>
	
</body>
</html>