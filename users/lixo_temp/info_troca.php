<?php
	spl_autoload_register(function($classe) {
        require('..\classes/'.$classe.'.class.php');
    });
    @BD::conn();//conexão com o banco de dados	
    
    $user  = new Usuarios();   
    $troca = new Trocas();
    $jogo  = new Jogos(); 
?>
<!DOCTYPE HTML>
<html lang="pt=BR">
	<head>
		<meta charset="UTF-8"/>
		<title>Proposta - Restart Games</title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
		<style>
			*{margin:0; padding:0;}
#box{
	width: 98%;
	border-radius:3px;
	background:#f0f0f0;
	display: block;		
	margin-bottom: 10%;
	padding:1%;	
}
.clearfix{
	padding-bottom: 15px;
}
.clearfix:after {    
 	content:".";   
    display:block; 
    height:0;    
    clear:both;  
    visibility: hidden;
 } 
#box > span:first-child{
	width: 100%;
	padding:15px 0;
	background:#069;
	display: block;
	text-align: center;
}
#box span:first-child h4{
	color:#fff;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 1.5em;
}
#box #jogoTroca{
	width: 100%;
	margin-top: 2%;
}
#box #jogoTroca .quadro{
	width: 40%;
	display: inline-block;	
}
#box #jogoTroca #left{
	float:left;
	padding:4px;
}
#box #jogoTroca #right{
	float:right;
}
#box #jogoTroca #left .boxEsquerda, #box #jogoTroca #right .boxDireita{
	width: 47%;
	display: inline-block;
}
.quadro .boxEsquerda{	
	float: left;	
	background-color: #ffffff;
}
.quadro .info h5{
	margin: 2%;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 0.8em;
	color:#000;
}
.quadro .info label{
	width: 97%;
	padding:4px 2px;
	color:#333;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 1em;
	display: block;
	text-align: left;
}
.quadro .boxDireita{
	float: right;
	background-color: #dadadb;
}
.quadro .jogo img{
	width: 80%;
	margin: 10%;
}
.quadro .jogo > span{
	width: 100%;	
	padding: 0 0 4px 0 ;
	text-align: center;
	display: block;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 1em;
	text-transform: uppercase;
	font-weight: bold;
	color:#069;
}

.quadro #tipoTroca, .quadro #valorTroca{
	width: 96%;
	padding:2%;
	background:#dddcdc;	
	text-align: center;	
}
.quadro #tipoTroca span,.quadro #valorTroca span{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 1em;
	color: #3e3e3e;	
}
.imgTroca{
	display:inline-block;
	margin-top:8%;
    width:10%;
    margin-left:5%;
}
.imgTroca img{ width: 100%; }

</style>
	</head>
	<body>		
		<div id="box">			
			<span><h4>PROPOSTA INDIVIDUAL</h4></span>
			<div id="jogoTroca">
				<div class="clearfix">
					<?php
					 if(isset($_POST['cod'])){
					 	$id = $_POST['cod'];
					 }	
					 foreach ($troca->find($id) as $tr => $t):
						
						foreach ($jogo->listaJogoById($t->jogoum) as $j => $game):						
					?>	
					<div id="left" class="quadro">
						<div class="clearfix">
							<div class="info boxEsquerda" id="myinfo">
								<h5>Descrição</h5>
								<label><?php echo $game->descricao?></label>
								<h5>Info Extra</h5>
								<label><?php echo $game->informacao?></label>
							</div>
							<div class="jogo boxEsquerda" id="mygame">
								<img src="..\game/imagens/<?php echo str_replace(' ', '',$game->nome_console)?>/<?php echo $game->imagem ?>" alt="<?php echo $game->n_jogo;?>"/>
								<span><?php echo $game->n_jogo .' - '. $game->nome_console ?></span>
							</div>
						</div>
						<div id="tipoTroca">
							<?php
								$tipo = $t->tipo;
								switch ($tipo) {
									case '0':
										$tipo = 'meu jogo vale MAIS';
									break;
									case '1':
										$tipo = 'equilibrado';
									break;
									case '2':
										$tipo = 'meu jogo vale MENOS';
									default:
										
										break;
								}
							?>
							<span>Tipo de TROCA: <b><?php echo $tipo?></b></span>
						</div>
					</div>
					<?php
						endforeach;
					
					?>
					<div class="imgTroca"><img src="../imagens/icones/troca.png" alt="Troca"/></div>
						<?php
							foreach ($jogo->listaJogoById($t->jogodois) as $j => $gm):						
						?>	
					<div id="right" class="quadro">
						<div class="clearfix">						
							<div class="info boxDireita">
								<h5>Descrição</h5>
								<label><?php echo $gm->descricao?></label>
								<h5>Info Extra</h5>
								<label><?php echo $gm->informacao?></label>
							</div>
							<div class="jogo boxDireita" id="seuJogo">
								<img src="..\game/imagens/<?php echo str_replace(' ','',$gm->nome_console)?>/<?php echo $gm->imagem?>" alt="<?php echo $gm->n_jogo;?>"/>
								<span><?php echo $gm->n_jogo .' - '. $gm->nome_console ?></span>
							</div>
						</div>
						<div id="valorTroca">
							<span>VALOR DE RETORNO: <b>R$<?php echo $t->valor.',00'?></b></span>
						</div>
					</div>
					<?php 
						endforeach;
					endforeach;
				
					?>
				</div>
			</div><!--JOGO TROCA-->			
		</div>
	</body>
</html>