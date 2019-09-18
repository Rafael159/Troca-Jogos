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

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">	
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">	
		<!--CSS PADRÃO-->	
		<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/dashboard.css" />
		<!--CSS BOOTSTRAP-->
		<!-- <link rel="stylesheet" type="text/css" href="..\bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="..\bootstrap/css/bootstrap-theme.css"/> -->

			
		<!--CSS FONT-AWESOME-->		
    	<link rel="stylesheet" type="text/css" href="..\font-awesome/css/font-awesome.css"/>		
		<link type="text/css" href="../css/fonts.css" rel="stylesheet"/>				
		<link rel="stylesheet" type="text/css" href="css/jogos.css"/>
		<link rel="stylesheet" type="text/css" href="css/home.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
		<title>Dashboard - Restart Games</title>
	</head>
<body>
	<div class="alert-overlay"></div>
	<?php
		$user = Usuarios::getUsuario();
		
		if(!isset($user->id_user)):
			header("Location: ..\index.php");
		endif;

		$nome = $user->nomeUser;
		$codigo = $user->id_user;
	?>
	<div class="container-fluid nopadding">
		<nav class="navbar navbar-expand-md navbar-dark">
			<a href="../index.php" class="navbar-brand nopadding" title="Home"><img src="../imagens/icones/logo.png" alt="Restart Games" class="img-responsive"/></a>
			
			<button class="navbar-toggler" data-toggle="collapse" data-target="#dashMenu">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="dashMenu">
				<ul class="navbar-nav ml-auto container-menu">
					<li class="menu-option"><a href="../index.php" title="Meu perfil" class="nav-link"  id="back"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar ao site</a></li>
					<li class="box-notification menu-option">
						<a href="#" title="Notificação" id="notification"><i class="fa fa-bell"></i> <span class="qnt-notice"><?php echo Notificacoes::contarNotificacoes(array('receptor'=>$codigo, 'lido'=>'nao'))?></span></a>
					</li>
					<li class="menu menu-option"><a href="profile.php" title="Meu perfil" class="nav-link" id="perfil_user"><i class="fa fa-user"></i> Perfil</a></li>
					<li class="menu-option"><a href="..\sair.php" title="Sair" class="nav-link" id="settings"><i class="fa fa-sign-out"></i> Sair</a></li>
				</ul>
			</div>   
			
				<div class="control-toggle">
            <button class="btn btn-primary" id="menu-toggle">Navegar <i class="fa fa-dashboard"></i></button>
        </div>         
		</nav>

		<div id="container">
			<div class="row nopadding">
				<!-- <div class="col-lg-1 col-md-2 col-sm-2 vertical_content nopadding" id="left">
					<span class="box_perfil hidden-xs">
						<img src="../imagens/icones/profile.png" class="img-responsive" alt="Foto perfil" id="foto_perfil"/>
						<small class="text-center"><?php //if(isset($nome)){echo $nome;}?></small>
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
				            <li class="vt_link text-center nav_op_left" id="jogos"><a href="jogos"><i class="fa fa-gamepad fa-3x"></i><br/>Jogos<br/><span class="badge"><?php //echo Jogos::contarJogosHelper(array('id_gamer'=> $codigo, 'status'=>'Ambos'))?></span></a></li>
				            <li class="vt_link text-center nav_op_left" id="trocas"><a href="trocas"><i class="fa fa-refresh fa-3x"></i><br/>Trocas <br/><span class="badge"><?php //echo Trocas::contaTrocasHelper(array('idgamer'=>$codigo, 'contar'=>'sim'))?></span></a></li>				            				            
				            <li class="vt_link text-center nav_op_left" id="mensagens"><a href="mensagens/chat"><i class="fa fa-commenting fa-3x"></i><br/>Mensagens<br/><span class="badge"><?php //echo Mensagens::countMensagens(array('cod_to'=>$codigo, 'lido'=>'nao')); ?></span></a></li>
				            <li class="vt_link text-center nav_op_left" id="contato"><a href="contato"><i class="fa fa-envelope fa-3x"></i><br/>Contate-nos</a></li>				             
				          </ul>
				        </div>
				      </div>
				    </div>
				</div> -->
				<div class="d-flex" id="wrapper">
					<div class="border-right" id="sidebar-wrapper">
						<div class="control-toggle">
							<button class="btn btn-danger" id="close-menu-toggle">Fechar <i class="fa fa-remove"></i></button>
						</div>
						<div class="col-md-3 col-lg-2 col-xs-1 p-l-0 p-r-0 collapsed in nopadding" id="sidebar">
							<div class="list-group panel">
								<ul class="nav navbar-nav" id="left_menu">
									<li class="vt_link nav_op_left" id="home">
										<a href="home" class="list-group-item" data-toggle="collapsed" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hidden-sm-down"> Dashboard</span></a>
									</li>
									<li class="vt_link nav_op_left" id="jogos">
										<a href="jogos" class="list-group-item" data-toggle="collapsed" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-gamepad"></i> Jogos <span class="badge"><?php echo Jogos::contarJogosHelper(array('id_gamer'=> $codigo, 'status'=>'Ambos'))?></span></a>
									</li>
									<li class="vt_link nav_op_left" id="trocas">
										<a href="trocas" class="list-group-item" data-toggle="collapsed" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-refresh"></i> Trocas <span class="badge"><?php echo Trocas::contaTrocasHelper(array('idgamer'=>$codigo, 'contar'=>'sim'))?></span></a>
									</li>
									<li class="vt_link nav_op_left" id="mensagens">
										<a href="mensagens/chat" class="list-group-item" data-toggle="collapsed" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-commenting"></i> Mensagens <span class="badge"><?php echo Mensagens::countMensagens(array('cod_to'=>$codigo, 'lido'=>'nao')); ?></span></a>
									</li>
									<li class="vt_link nav_op_left" id="contato">
										<a href="contato" class="list-group-item" data-toggle="collapsed" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-envelope"></i> Contate-nos</a>
									</li>
								</ul>

								<!--Início exemplo drop-menu-->
									<!-- <a href="#menu1" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-dashboard"></i> <span class="hidden-sm-down">Item 1</span> </a>
									
									<div class="collapse" id="menu1">
										<a href="#menu1sub1" class="list-group-item" data-toggle="collapse" aria-expanded="false">Subitem 1 </a>
										<div class="collapse" id="menu1sub1">
											<a href="#" class="list-group-item" data-parent="#menu1sub1">Subitem 1 a</a>
											<a href="#" class="list-group-item" data-parent="#menu1sub1">Subitem 2 b</a>
											<a href="#menu1sub1sub1" class="list-group-item" data-toggle="collapse" aria-expanded="false">Subitem 3 c </a>
											<div class="collapse" id="menu1sub1sub1">
												<a href="#" class="list-group-item" data-parent="#menu1sub1sub1">Subitem 3 c.1</a>
												<a href="#" class="list-group-item" data-parent="#menu1sub1sub1">Subitem 3 c.2</a>
											</div>
											<a href="#" class="list-group-item" data-parent="#menu1sub1">Subitem 4 d</a>
											<a href="#menu1sub1sub2" class="list-group-item" data-toggle="collapse"  aria-expanded="false">Subitem 5 e </a>
											<div class="collapse" id="menu1sub1sub2">
												<a href="#" class="list-group-item" data-parent="#menu1sub1sub2">Subitem 5 e.1</a>
												<a href="#" class="list-group-item" data-parent="#menu1sub1sub2">Subitem 5 e.2</a>
											</div>
										</div>
									</div> -->
								<!--Fim do exemplo drop-menu-->

							</div>
						</div>
					</div>
					<div id="page-content-wrapper">
						<div class="col-lg-12 col-xs-12 vertical_content right" id="conteudo">
							<!--/ Todo o conteúdo vem aqui-->
						</div>
					</div>
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
		
	<!--CHAMADA JAVASCRIPT-->
	<!-- <script type="text/javascript" src="../js/jquery.js"></script> -->

	<script
  src="https://code.jquery.com/jquery-3.4.0.js"
  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
  crossorigin="anonymous"></script>
	<script src="js/jquery.form.min.js"></script>
	<!--JS BOOTSTRAP-->
	<!-- <script src="../bootstrap/js/bootstrap.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/principal.js"></script>

</body>
</html>



