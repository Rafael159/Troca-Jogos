<?php
	spl_autoload_register(function($classe) {
        require('..\classes/'.$classe.'.class.php');
    });
    @BD::conn();//conexão com o banco de dados	
    
    $jogo = new Jogos(); //chama a classe Jogos
?>
<!DOCTYPE HTML>
<html lang="pt=BR">
	<head>
		<meta charset="UTF-8"/>
		<title>Troca efetuada</title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
	</head>
	<body>
		<div id="conteudo"></div>
		<div id="box">			
			<span><h4>PROPOSTA ENVIADA</h4></span>
			<div id="jogoTroca">
				<div class="clearfix">
					<?php
					if(isset($_GET['id']) AND $_GET['id'] !== ''){
						$idJogo = $_GET['id'];//id do jogo desejado

						//buscar o jogo selecionado
						$sql = "SELECT * FROM `jogos` as j,`console` as c, `imagens` as i WHERE j.id = $idJogo AND j.id_console = c.id_console AND j.img_jogo = i.id_img";
						foreach ($jogo->consulta($sql) as $chave => $valor):							
					?>	
					<div id="left" class="quadro">
						<div class="clearfix">
							<div class="info boxEsquerda" id="myinfo">
								<h5>Descrição</h5>
								<label><?php echo $valor->descricao?></label>
								<h5>Info Extra</h5>
								<label><?php echo $valor->informacao?></label>
							</div>
							<div class="jogo boxEsquerda" id="mygame">
								<img src="imagens/<?php echo str_replace(' ', '',$valor->nome_console)?>/<?php echo $valor->imagem ?>" alt="<?php echo $valor->n_jogo;?>"/>
								<span><?php echo $valor->n_jogo .' - '. $valor->nome_console ?></span>
							</div>
						</div>
						<div id="tipoTroca">
							<?php
								$tipo = $_GET['tipo'];
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
					}
					?>
					<div class="imgTroca"><img src="../imagens/icones/troca.png" alt="Troca"/></div>
						<?php
						if(isset($_GET['id2']) AND $_GET['id2'] !== ''){
							$idJogo2 = $_GET['id2'];//id do jogo desejado

							//buscar o jogo selecionado
							$sql = "SELECT * FROM `jogos` as j,`console` as c, `imagens` as i WHERE j.id = $idJogo2 AND j.id_console = c.id_console AND j.img_jogo = i.id_img";
							foreach ($jogo->consulta($sql) as $chave => $valor):							
						?>	
					<div id="right" class="quadro">
						<div class="clearfix">						
							<div class="info boxDireita">
								<h5>Descrição</h5>
								<label><?php echo $valor->descricao?></label>
								<h5>Info Extra</h5>
								<label><?php echo $valor->informacao?></label>
							</div>
							<div class="jogo boxDireita" id="seuJogo">
								<img src="imagens/<?php echo str_replace(' ','',$valor->nome_console)?>/<?php echo $valor->imagem?>" alt="<?php echo $valor->n_jogo;?>"/>
								<span><?php echo $valor->n_jogo .' - '. $valor->nome_console ?></span>
							</div>
						</div>
						<div id="valorTroca">
							<span>VALOR DE RETORNO: <b>R$<?php echo $_GET['valor'].',00'?></b></span>
						</div>
					</div>
					<?php 
						endforeach;
					}
					?>
				</div>
			</div><!--JOGO TROCA-->
			<div id="mensagem">
				<label>
					<?php echo $_GET['mensagem'];?>
				</label>
			</div>
			<div id="path">
				<a href="../index.php"><span class="btnGo pgprincipal">Ver mais jogos</span></a>
				<a href="../users/myarea.php"><span class="btnGo pgadmin">Área principal</span></a>
			</div>
		</div>
	</body>
</html>