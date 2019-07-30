<?php
	header("Content-Type: text/html;  charset=UTF-8",true);
	spl_autoload_register(function($classe) {
		require(dirname(__FILE__).'/classes/'.$classe.'.class.php');
    });
    @BD::conn();

    $jogos = new Jogos();
    $usuario = new Usuarios();
	$console = new Consoles();
	$key = ( isset($_GET['pesquisa']) AND !empty($_GET['pesquisa'])) ? $_GET['pesquisa'] : '';
		
	$pos = strpos($key, '-');//posição do "-"
	
	if($pos){
		$cnsl = trim(substr(strrchr($key, '-'), 1));
		$key = trim(substr($key, 0, $pos));//retira o nome do console
	}	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="Restart Games - Porque o jogo não pode parar"/>
		<meta name="description" content="Troque seus jogos antigos por jogos que ainda não teve"/>
		<meta name="description" content="Troque jogos - divirta-se sem gastar mais"/>
		<meta name="keywords" content="Restart, Games, Troca,Jogo, Jogadores,Console, Diversão"/>
		<title>Restart Games - Pesquise jogos para trocar</title>
		
		<!--CHAMADAS CSS-->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css"/>

		<link rel="stylesheet" type="text/css" href="css/pesquisa.css">
		<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
		<link rel="stylesheet" type="text/css" href="css/style-footer.css"/>
		<link rel="stylesheet" type="text/css" href="css/fonts.css"/>
		<link rel="stylesheet" type="text/css" href="css/header.css"/><!--estilo topo-->
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
			(adsbygoogle = window.adsbygoogle || []).push({
				google_ad_client: "ca-pub-6141840476591418",
				enable_page_level_ads: true
			});
        </script>
	</head>
<body>
	

	<?php include_once('require/header.php'); ?>
	<div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">
                <span class="sidebar-title">Filtrar por: </span>
                <div class="control-toggle">
                    <button class="btn btn-danger" id="close-menu-toggle">Fechar <i class="fas fa-remove"></i></button>
                </div>
             </div>
            <div class="list-group list-group-flush">
                <?php require ('require/sidebar_filtros.php');?> <!--chama o sidebar com os filtros para a pesquisa-->        
            </div>
        </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="control-toggle">
            <button class="btn btn-primary" id="menu-toggle">Filtros <i class="fas fa-filter"></i></button>
        </div>
      <div class="container-fluid nopadding">
        <div id="box-resultados">	
            <label id="progress"><img src="imagens/icones/progresso.gif"/></label>
            <div class="row nopadding">
            <?php		
                if($key):	
                    if(isset($cnsl)){
                        $grupoJogos = $jogos->listarJogos(array('status'=>'Ativo', 'order'=>'ORDER BY id DESC', 'jogo'=>$key, 'console'=>$cnsl));
                    }else{
                        $grupoJogos = $jogos->listarJogos(array('status'=>'Ativo', 'order'=>'ORDER BY id DESC', 'jogo'=>$key));
                    }
                $qtd = count($grupoJogos);
                if($qtd != 0):
                    foreach($grupoJogos as $valor):
            ?>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 nopadding">
                <div class="contorno">				
                    <figure id="console" nome="<?php echo strtoupper($valor->nome_console)?>" class="<?php echo strtolower($valor->nome_console)?>"><a href="game/game.php?codigo=<?php echo $valor->id;?>&&console=<?php echo $valor->id_console;?>"> <img src="game/imagens/<?php echo str_replace(' ', '',$valor->nome_console)?>/<?php echo $valor->imagem?>" alt="<?php echo strtoupper($valor->n_jogo)?>" class="image-game"/></a></figure>
                    <div class="info-gamer">
                        <ul>
                            <li>
                                <?php
                                    $num = strlen($valor->n_jogo);
                                    if($num >15){
                                        echo trim(substr($valor->n_jogo,0,15)).'...';
                                    }else{
                                        echo strtoupper($valor->n_jogo);
                                    }
                                ?>
                            </li>
                            <li><?php echo strtoupper($valor->nome_console)?></li>
                            <li><a href="feed.php?codigo=<?php echo $valor->id_user?>" class="usuario"><?php echo $valor->nomeUser;?></a></li>
                            <li><?php echo ($valor->cidade) ? substr($valor->cidade,0,10) : '' ." ". ($valor->estado) ? $valor->estado : ''?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
                endforeach;
                else:
                    echo "<span class='alert-vazio'><p>OPS! Nenhum jogo encontrado :( </p><p>Tente outra pesquisa... </p></span>";
                endif;
            else:
                foreach($jogos->listarJogos(array('status'=>'Ativo', 'order'=>"ORDER BY id DESC")) as $key=> $valor):
            ?> 
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 nopadding">
                <div class="contorno">				
                    <figure id="console" nome="<?php echo strtoupper($valor->nome_console)?>"  class="<?php echo strtolower($valor->nome_console)?>"><a href="game/game.php?codigo=<?php echo $valor->id;?>&&console=<?php echo $valor->id_console;?>"><img src="game/imagens/<?php echo str_replace(' ', '', $valor->nome_console)?>/<?php echo $valor->imagem?>" alt="<?php echo strtoupper($valor->n_jogo)?>" class="image-game" /></a></figure>
                    <div class="info-gamer">
                        <ul>
                            <li>
                                <?php
                                    $num = strlen($valor->n_jogo);
                                    if($num >15){
                                        echo substr($valor->n_jogo,0,15).'...';
                                    }else{
                                        echo strtoupper($valor->n_jogo);
                                    }
                                ?>
                            </li>
                            <li><?php echo strtoupper($valor->nome_console)?></li>						
                            <li><a href="feed.php?codigo=<?php echo $valor->id_user?>" class="usuario"><?php echo substr($valor->nomeUser, 0,20)?></a></li>
                            <li><?php echo substr($valor->cidade,0,10) ." - ". $valor->estado?></li>						
                        </ul>
                    </div>
                </div>
            </div>
                <?php		
                endforeach;//fecha o While dos jogos gerais
            endif; ?>
            </div>
            </div>            
        </div>
    </div>
    <!-- /#page-content-wrapper -->
  </div>
    <?php
        require 'footer.php';
    ?>
	<!--CHAMADA JAVASCRIPT-->		
	<script src="js/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/global.js"></script>
	<script src="js/funcoes.js"></script>
	<script type="text/javascript" src="js/events.js"></script>
</body>
</html>