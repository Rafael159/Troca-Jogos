<?php
	spl_autoload_register(function($classe) {
		require(dirname(dirname((__FILE__))).'/classes/'.$classe.'.class.php');
	});
	$imagem  = new Imagens;

	$id = $_POST['id'];

	$sql = "SELECT * FROM `console` as c, `imagens` as i WHERE c.id_console = i.id_console AND i.id_console = $id ORDER BY i.id_img";
	$qnt = count($imagem->consulta($sql));	
		if($qnt == 0){
			echo "<span id='msg-none'>NENHUMA IMAGEM CADASTRADA</span>";
		}else{
			foreach($imagem->consulta($sql) as $img=> $valor):								
?>
		<div class="each-img">
			<img src="../game/imagens/<?php echo str_replace(' ', '', $valor->nome_console) ?>/<?php echo $valor->imagem?>" alt="<?php echo $valor->nome?>">
			<div class="box-opcao">
				<span><input type="text" value="<?php echo $valor->nome?>" class="nm_jogo"/></span>
				<ul id="<?php echo $valor->id_img;?>">
					<li><img src="images/deletar.png" alt="Deletar" class="icon-deletar"></li>
					<li><img src="images/editar.png" alt="Editar" class="icon-editar"></li>
				</ul>
			</div>
		</div>
<?php 
	endforeach;
	}
?>