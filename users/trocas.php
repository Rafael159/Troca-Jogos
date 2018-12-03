<?php
	function __autoload($classe){
        require('..\classes/'.$classe.'.class.php');
    }
        
    $user  = new Usuarios();   
    $troca = new Trocas();
    $jogo  = new Jogos(); 

    session_start();
    if($_SESSION['emailTJ']):
    	$email = $_SESSION['emailTJ'];
    else:
    	header("Location:index.php");
    endif;

    $user->setEmail($email);
    foreach ($user->findEmail() as $usuario) {
    	$id = $usuario->id_user;
    }
?>
<link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
<link rel="stylesheet" type="text/css" href="css/trocas.css"/>

<div class="row nopadding">
	<div class="col-lg-12 nopadding">
		<div id="ctr_trocas">
			<header>
				<h3 class="title_page">/ MINHAS TROCAS</h3>
			</header>
			<div class="col-lg-12">
				<a href="..\pesquisa.php" id="add_troca"><i class="fa fa-plus-square fa-5x"></i><br/><strong>Add troca</strong></a>
				<div class="btn-group">
					<button type="button" class="btn btn-primary btn_exchange" id="all">Todas</button>
					<button type="button" class="btn btn-success btn_exchange" id="accepted">Aceitas</button>
					<button type="button" class="btn btn-warning btn_exchange" id="done">Feitas</button>
					<button type="button" class="btn btn-info btn_exchange" id="received">Recebidas</button>
					<button type="button" class="btn btn-danger btn_exchange" id="refused">Recusadas</button>
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
			<div class="modal fade" id="msg_erro" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
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
			</div>
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