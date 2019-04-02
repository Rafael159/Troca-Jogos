<?php
	@BD::conn();//conexão com o banco de dados

	function __autoload($classe){
		require('..\classes/'.$classe.'.class.php');
	}
	$jogos = new Jogos();
	$console = new Consoles();
	$usuario = new Usuarios();
	$trocas = new Trocas();
	$msg = new Mensagens();
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
					<a href="../index.php" class="navbar-brand nopadding" title="Home"><img src="../imagens/backgrounds/logo.png" alt="Troca Jogos" class="img-responsive"/></a>
				</div>
				<div class="collapse navbar-collapse" id="main-menu">
					<ul class="nav navbar-nav navbar-right container-menu">
						<!-- <li class="menu"><a href="settings.php" title="Configuração" class="link-main" id="settings"><i class="fa fa-cog"></i> Configuração</a></li> -->
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
				            <li class="vt_link text-center nav_op_left" id="trocas"><a href="trocas"><i class="fa fa-refresh fa-3x"></i><br/>Trocas <br/><span class="badge"><?php $trocas->setByUser($codigo); echo $trocas->contaTrocaById()?></span></a></li>				            				            
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
	</div>
		<?php
			else:
				header("Location: ..\index.php");
			endif;
		?>
	<!--CHAMADA JAVASCRIPT-->
	<!--<script type="text/javascript" src="../js/jquery.js"></script>chama o arquivo principal do jquery-->

	<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/principal.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<!--JS BOOTSTRAP-->
	<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>



