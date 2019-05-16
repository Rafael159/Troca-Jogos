<?php
	spl_autoload_register(function($classe) {
        require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');
    });
        
    $user  = new Usuarios();   
    $troca = new Trocas();
    $jogo  = new Jogos();

	$usuario = Usuarios::getUsuario();
	
	if($usuario):
		$email = $_SESSION['emailTJ'];
		$id = $_SESSION['id_user'];
	else:
		header("Location:index.php");
	endif;  
?>
<!-- <link rel="stylesheet" type="text/css" href="../css/fonts.css"/> -->
<link rel="stylesheet" type="text/css" href="css/trocas.css"/>

<div class="row nopadding">
	<div class="col-lg-12 nopadding">
		<div id="ctr_trocas">
			<header>
				<h3 class="title_page">/ MINHAS TROCAS</h3>
				<?php
					echo dirname(dirname(__FILE__));
				?>
			</header>
					
			<div class="col-lg-12">
				<a href="..\pesquisa.php" id="add_troca"><i class="fa fa-plus-square fa-5x"></i><br/><strong>Add troca</strong></a>
				<div class="btn-group">
					<button type="button" class="btn btn-default btn_exchange" id="all">Todas</button>
					<button type="button" class="btn btn-success btn_exchange" id="accepted">Aceitas</button>
					<button type="button" class="btn btn-warning btn_exchange" id="done">Feitas</button>
					<button type="button" class="btn btn-info btn_exchange" id="received">Recebidas</button>
					<button type="button" class="btn btn-danger btn_exchange" id="refused">Recusadas</button>
					<button type="button" class="btn btn-primary btn_exchange" id="finished">Finalizadas</button>
				</div>				
			</div>
			<div class="col-lg-12">
				<div class="tr_container">
					<!-- // Recebe conteúdo das trocas-->
					<div id="list" class="row"></div><!--/#list -->
				</div><!--/.tr_container -->
			</div>
			<!-- Modal -->
			<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
			    <div class="modal-dialog" role="document">
			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
			                <h4 class="modal-title" id="modalLabel">Excluir Item</h4>
			            </div>
			            <div class="modal-body">Deseja realmente excluir esta troca? </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-primary">Sim</button>
			                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
			            </div>
			        </div>
			    </div>
			</div>

			<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
			    <div class="modal-dialog" role="document">
			        <div class="modal-content">
			            <div class="modal-header">	
			            	<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>		                
			                <h4 class="modal-title">Informações da Troca</h4>
			            </div>
			            <div class="modal-body">
			            	<div class="row">
			            		<div id="view_troca">
			            		<!-- mostra os dados da troca -->
			            		</div><!-- /end #view_troca -->
			            	</div>
			            </div>			            
			        </div>
			    </div>
			</div>

			<div class="modal fade nopadding" id="modal-accepted" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
			    <div class="modal-dialog" role="document">
			        <div class="modal-content">
			            <div class="modal-header">	
			            	<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>		                
			                <h4 class="modal-title">Envie uma mensagem</h4>
			            </div>
			            <div class="modal-body" style="padding:30px;">
			            	<div class="row">
								<label class="msglinha"><b>Para</b> <span class="msgpara"></span></label>
			            		<form method="post" name="mensagem-aceito" class="form">
									<input type="hidden" name="by_user">
									<textarea class="form-control msgaceite" name="msgaceite" placeholder="Gostaria de deixar uma mensagem para o dono?"></textarea> 
									<button class="btn btn-primary" name="btnsendclose">Enviar e fechar</button>
								</form>
								<span class="alert alert-danger" style="display: block;"><b>Observação:</b> A mensagem não é obrigatória. Preencher se quiser informar algo para o dono do jogo ou combinar algo referente a troca</span>
			            	</div>
			            </div>			            
			        </div>
			    </div>
			</div>

			<div class="modal fade nopadding" id="modal-finaliza" taxindex="1" role="dialog" aria-labelledby="modalLabel">
				<div class="modal-dialog" role="document">
			        <div class="modal-content">
						<input type="hidden" name="idtroca"/>
			            <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
			                <h4 class="modal-title" id="modalLabel">Finalizar troca</h4>
			            </div>
			            <div class="modal-body">
							<span class="alert" style="display:block"><b>Importante: </b> Somente finalize a troca quando ambos os usuários já estivem com os novos jogos ou desistirem da troca</span>
							<span>
								<h5>Há duas formas de finalizar a troca: </h5>
								<span class="alert alert-info" style="display:block">Troca finalizada - Ambos os usuários já pegaram os novos jogos (os jogos passarão para os status <b>INATIVOS</b> e não poderão mais ser usados em futuras trocas)</span>
								<span class="alert alert-danger" style="display:block">Desistimos da troca - Os usuários desistiram da troca (os jogos continuarão <b>ATIVOS</b> para outras trocas)</span>
							</span>
						</div>
			            <div class="modal-footer">
							<button type="button" class="btn btn-default" onclick="update(0, 'Cancelada')">Desistimos da troca</button>
							<button type="button" class="btn btn-primary" onclick="update(0, 'Finalizada')">Troca finalizada</button>
			            </div>
			        </div>
			    </div>
			</div>
			<!-- <div class="modal fade" id="msg_erro" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
			    <div class="modal-dialog" role="document">
			        <div class="modal-content">
			            <div class="modal-header">			                
			                <h4 class="modal-title" id="modalLabel">Excluir Item</h4>
			            </div>
			            <div class="modal-body"><span></span></div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-primary" id="btn-deletar">Sim</button>
			                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
			            </div>
			        </div>
			    </div>
			</div> -->

			<div class="modal fade" id="box_error" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
			    <div class="modal-dialog" role="document">
			        <div class="modal-content">
			            <div class="modal-header">			                
			            	<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
			                <h4 class="modal-title text-center">Mensagem de alerta</h4>
			            </div>
			            <div class="modal-body">
			            	<div id="box-msg-error">
			            	</div>
			           	</div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>
<!--CHAMADA JS-->	
<script type="text/javascript" src="js/events-troca.js"></script>