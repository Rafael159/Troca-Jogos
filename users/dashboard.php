<?php

	spl_autoload_register(function($classe) {
		require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');
	});
	$jogos = new Jogos();
	$console = new Consoles();
	$usuario = new Usuarios();
	$trocas = new Trocas();
	$msg = new Mensagens();
	$notice = new Notificacoes();
?>

<html>
	<head>
		<meta charset="UTF-8">		
		<!--CSS PADRÃO-->		
		<link rel="stylesheet" type="text/css" href="css/dashboard.css" />
		<!--CSS BOOTSTRAP-->
		<link rel="stylesheet" type="text/css" href="..\bootstrap/css/bootstrap.min.css"/>
    	<link rel="stylesheet" type="text/css" href="..\bootstrap/css/bootstrap-theme.css"/>
		<!--CSS FONT-AWESOME-->		
    	<link rel="stylesheet" type="text/css" href="..\font-awesome/css/font-awesome.css"/>		
		<link type="text/css" href="../css/fonts.css" rel="stylesheet"/>				
		<link rel="stylesheet" type="text/css" href="css/jogos.css"/>
		<link rel="stylesheet" type="text/css" href="css/home.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
		<title>Dashboard - Troca Jogos</title>
	</head>
<body>
	<div class="alert-overlay"></div>
	<?php
		$user = Usuarios::getUsuario();
		
		if(isset($user->id_user)):
			$nome = $user->nomeUser;
			$codigo = $user->id_user;
		?>	
	<div class="container-fluid nopadding">
		<nav class="navbar navbar-default topHeader">
	        <div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
						<span class="sr-only">Toggle navegation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button> 
					<a href="../index.php" class="navbar-brand nopadding" title="Home"><img src="../imagens/icones/logo.png" alt="Troca Jogos" class="img-responsive"/></a>
				</div>
				<div class="collapse navbar-collapse" id="main-menu">
					<ul class="nav navbar-nav navbar-right container-menu">
						<!-- <li class="menu"><a href="settings.php" title="Configuração" class="link-main" id="settings"><i class="fa fa-cog"></i> Configuração</a></li> -->
						<li class=""><a href="../index.php" title="Meu perfil" class="link-main"  id="back"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar ao site</a></li>
						<li class="box-notification">
							<a href="#" title="Notificação" id="notification" style="color:#b70202; "><i class="fa fa-bell"></i> <span class="qnt-notice"><?php echo Notificacoes::contarNotificacoes(array('receptor'=>$codigo, 'lido'=>'nao'))?></span></a>
						</li>
						<li class="menu"><a href="profile.php" title="Meu perfil" class="link-main" id="perfil_user"><i class="fa fa-user"></i> Perfil</a></li>
						<li class=""><a href="..\sair.php" title="Sair" class="link-main" id="settings"><i class="fa fa-sign-out"></i> Sair</a></li>
					</ul>
				</div>							
			</div>
		</nav>
		
		<div id="container">
			<div class="row nopadding">
				<div class="col-lg-1 col-md-2 col-sm-2 vertical_content nopadding" id="left">
					<span class="box_perfil hidden-xs">
						<img src="../imagens/icones/profile.png" class="img-responsive" alt="Foto perfil" id="foto_perfil"/>
						<small class="text-center"><?php if(isset($nome)){echo $nome;}?></small>
					</span>
					<div class="sidebar-nav">
				      <div class="navbar navbar-default" role="navigation">
				        <div class="navbar-header">
				          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
				            <span class="sr-only">Toggle navigation</span>
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
				          </button>
				        </div>
				        <div class="navbar-collapse collapse sidebar-navbar-collapse nopadding">
				          <ul class="nav navbar-nav" id="left_menu">
				            <li class="vt_link text-center nav_op_left" id="home"><a href="home"><i class="fa fa-tachometer fa-3x"></i><br/>Dashboard</a></li>
				            <li class="vt_link text-center nav_op_left" id="jogos"><a href="jogos"><i class="fa fa-gamepad fa-3x"></i><br/>Jogos<br/><span class="badge"><?php echo Jogos::contarJogosHelper(array('id_gamer'=> $codigo, 'status'=>'Ambos'))?></span></a></li>
				            <li class="vt_link text-center nav_op_left" id="trocas"><a href="trocas"><i class="fa fa-refresh fa-3x"></i><br/>Trocas <br/><span class="badge"><?php echo Trocas::contaTrocasHelper(array('idgamer'=>$codigo, 'contar'=>'sim'))?></span></a></li>				            				            
				            <li class="vt_link text-center nav_op_left" id="mensagens"><a href="mensagens/chat"><i class="fa fa-commenting fa-3x"></i><br/>Mensagens<br/><span class="badge"><?php echo Mensagens::countMensagens(array('cod_to'=>$codigo, 'lido'=>'nao')); ?></span></a></li>
				            <!-- <li class="vt_link text-center nav_op_left" id="contato"><a href="contato"><i class="fa fa-envelope fa-3x"></i><br/>Contate-nos</a></li>				             -->
				          </ul>
				        </div><!--/.nav-collapse -->
				      </div>
				    </div>
				</div>
				<div class="col-lg-11 col-md-10 col-sm-10 vertical_content right " id="conteudo">
					<!--/ Todo o conteúdo vem aqui-->
				</div>
			</div>
		</div>
		<div class="toast">
			<div class="toast_title">Notificações</div>
			<?php
				$notificacoes = $notice->getNotificacoes(array('receptor'=>$codigo, 'lido'=>'nao'));
				if(count($notificacoes)):
					foreach($notificacoes as $notices => $notice):
				?>
					<div class="toast__content toast_<?php echo $notice->tipo; ?> toast_id_<?php echo $notice->id;?>">
						<div class="toast_header">						
							<div class="toast__icon toast_back_<?php echo $notice->tipo; ?>">
								<?php
									switch($notice->tipo){
										case("info"):
											$icon = "info";
											break;
										case("warning"):
											$icon = "exclamation";
											break;
										case("success"):
											$icon = "check";
											break;
										default:
											$icon = "check";
									}
								?>
								<i class="fa fa-<?php echo $icon; ?> fa-2x"></i>
							</div>
							<p class="toast__type"><?php echo $notice->titulo; ?></p>
							<div class="toast__close" id="<?php echo $notice->id; ?>">
								<span class="toast_btn"><i class="fa fa-eye"></i></span>
							</div>
						</div>
						<p class="toast__message"><?php echo $notice->mensagem; ?></p>						
					</div>
				<?php endforeach; ?>
				<?php else: ?>
					<div class="toast_no_message">
						<span>Você não possui nenhuma notificação</span>
					</div>
				<?php endif; ?>
		
		</div>
		<div id="response">
			<div class="response_title">Alerta</div>
			<span class="response_message">Marcar mensagem como lida?</span>
			<div class="response_buttons">
				<button class="rps_btn btn btn-danger"  onclick="closenotice()">Não</button>			
				<button class="rps_btn btn btn-success" id="btn-read" onclick="readnotice()">Sim</button>
			</div>
		</div>
	</div>
		<?php
			else:
				header("Location: ..\index.php");
			endif;
		?>
	<!--CHAMADA JAVASCRIPT-->
	<!--<script type="text/javascript" src="../js/jquery.js"></script>chama o arquivo principal do jquery-->

	<script
  src="https://code.jquery.com/jquery-3.4.0.js"
  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
  crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/principal.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<!--JS BOOTSTRAP-->
	<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>



