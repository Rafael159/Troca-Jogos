<?php
	spl_autoload_register(function($classe) {
        require('../../classes/'.$classe.'.class.php');
    });
	session_start();
	$user = new Usuarios;
	$console = new Consoles;
	$imagem  = new Imagens;
	$jogo = new Jogos;
	$generos = new Generos();

	if(isset($_SESSION['emailTJ'])){
		$emailUser = $_SESSION['emailTJ'];	
		$idUser = $_SESSION['id_user'];
	}
	?>
	<title>Jogos</title>
	<div class="col-lg-6 col-lg-push-3">
		<!--SERÁ CARREGADO AS INFORMAÇÕES DOS JOGOS PARA ATUALIZAR OU DELETA<div id="boxAtualiza"></div>-->
	</div>	
	<div class="row nopadding">
		<div class="col-lg-12 nopadding">			
			<div id="main_game">
				<header>
					<h3 class="title_page">Gerenciamento do jogos</h3>								
				</header>

				<div class="box_jogos">
					<?php
						$row = $jogo->listarJogos(array('status'=>'Ambos', 'order'=>'ORDER BY j.id DESC'));
                        $qnt = count($row);
                        
						if($qnt == 0){
							echo "<span id='msg-none'>NENHUM JOGO CADASTRADO</span>";
						}else{
                        ?>
                        <div class="col-lg-12 boxqntjogos">Jogos encontrados <span id="qntjogos">( <?php echo $qnt; ?> )</span></div>
                        <?php
							foreach ($row as $jogo=> $valor):
					?>
					<div class="each-game col-lg-3 col-md-4 col-sm-6 col-xs-12 <?php echo ($valor->status == 'Inativo') ? 'inativo' : ''; ?>" id="<?php echo $valor->id?>">
						<img src="../game/imagens/<?php echo str_replace(' ', '', $valor->nome_console) ?>/<?php echo $valor->imagem?>" alt="<?php echo $valor->nome?>">
						<div class="box-opcao">
							<span class="nm_jogo"><?php echo strtoupper($valor->n_jogo)?></span>					
						</div>						
					</div>
					<?php
						endforeach;
					}
					?>
				</div>				
			</div>

			<!--MODAL ATUALIZA OU DELETA JOGO-->
			<div class="modal fade" id="up_del_game">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background:#fff">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h1 class="title_modal">Detalhes do jogo <i class="fa fa-gamepad fa-lg"></i></h1>
						</div>
						<div class="modal-body">
							<div id="boxAtualiza"></div>
						</div>
					</div>	
				</div>				
			</div>		
		</div><!-- / .col-lg-12 -->
	</div><!-- / .row -->

<!--CHAMADA JS-->	

<!-- <script src="../js/funcoes.js" type="text/javascript"></script>
<script src="js/acoes.js" type="text/javascript"></script> -->

<script>
    $(document).ready(function(){
        $('.each-game').click(function(){
            idJ = $(this).attr('id');
            
            /*faz requisição e retorna o jogo pelo ID*/
            $.ajax({
                url: "../users/consulta_jogo.php",/*arquivo que faz a requisição*/
                type: "POST",
                dataType:'html',
                data:'idJ='+ idJ,/*ID do jogo*/
                success : function(data){
                /*levar a página para o topo e remover o scroll da página*/
                var body = $("html, body");
                body.stop().animate({scrollTop:0}, '500', 'swing');											
                    $('#up_del_game').modal('show');
                    
                    $('#boxAtualiza').html('<img src="../imagens/backgrounds/progresso.gif" alt="Loading...">');
                    setTimeout(function(){
                        $('#boxAtualiza').html(data);
                    },2000);			
                },
                error: function(jqXHR, textStatus, errorThrown){
                    $('#up_del_game').modal('show');
                    $('#boxAtualiza').text("Desculpa :( Ocorreu um erro no carregamento do jogo! Tente novamente");
                }
            });
        });
    });
</script>
