<?php
	spl_autoload_register(function($classe) {
		require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');
	});
	session_start();
	$user = new Usuarios;
	$console = new Consoles;
	$imagem  = new Imagens;
	$jogo = new Jogos;
	$generos = new Generos();

	$usuario = Usuarios::getUsuario();

	if($usuario){
		$emailUser = $usuario->emailTJ;	
		$idUser = $usuario->id_user;
	}
	?>
					
	<div class="col-lg-6 col-lg-push-3">
		<!--SERÁ CARREGADO AS INFORMAÇÕES DOS JOGOS PARA ATUALIZAR OU DELETA<div id="boxAtualiza"></div>-->
	</div>
	<div id="feedback_message">
	    <div class="box-dialog">
	        <div class="box-content">					           
	            <div class="box-header">
	                <h4 id="message"></h4>
	            </div>	
	            <div class="box-body">
	            	<button id="confirm-record" class="btn btn-success">Confirmar</button>		            
	            </div>
	        </div>
	    </div>
	</div>
	<div class="row nopadding">
		<div class="col-lg-12 nopadding">			
			<div id="main_game">
				<header>
					<h3 class="title_page">/ MEUS JOGOS</h3>								
				</header>
				<span id="add_game" data-toggle="modal" data-target="#modal-add-game"><i class="fa fa-plus-square fa-5x"></i><br/><strong>Add jogo</strong></span>

				<div class="box_jogos">
					<div class="alert alert-info">Aqui ficam todos os seus jogos. ATIVOS E INATIVOS<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
					<div class="row">
						<?php												
							$jogo->setIdGamer($idUser);
							$qnt = $jogo->contaJogoById();
							
							$row = $jogo->listarJogos(array('id_gamer'=>$idUser, 'status'=>'Ambos', 'order'=>'ORDER BY j.id DESC'));
							
							if($qnt == 0){
								echo "<span id='msg-none'>NENHUM JOGO CADASTRADO</span>";
							}else{
								foreach ($row as $jogo=> $valor):
						?>
							<div class="each-game col-lg-3 col-md-6 col-sm-6 col-xs-12 <?php echo ($valor->status == 'Inativo') ? 'inativo' : ''; ?>" id="<?php echo $valor->id?>" >
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
			</div>

			<!--MODAL ADD JOGO-->
			<div class="modal fade" id="modal-add-game" data-backdrop="static">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h1 class="title_modal">Adicionar jogo <i class="fa fa-gamepad fa-lg"></i></h1>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="content">									
									<form id="frm_jogos" action="" class="form">										
										<div class="col-lg-12">
											<label for="console">Console</label>
											<input type="hidden" id="codconsole" name="codconsole">									
											<select name="console" id="console_add_game" class="form-control" required>
												<option value="">Selecione o console</option>												
											</select>											
										</div>	
										<div class="col-lg-12">					
											<label for="jogo">Jogo</label>
											<input type="text" name="jogo" id="jogo" class="form-control" placeholder="nome do jogo" required/>
										</div>										
										<div class="col-lg-12">
											<label for="imagem">Imagem</label>
											
											<div class="row">
												<div class="col-lg-3">
													<div class="deleteImg" id="delete_primeira_img"><img src="img/pop-botao-fecha.png" id="pop_botao_fecha"/></div>
											
													<div class="boximg" id="boxmeujogo"><!--RECEBE A IMAGEM DO JOGO--></div>
													<input type="hidden" name="img_id" id="img_id"/>
												</div>
												<div class="col-lg-9">
													<div id="imagem" class="imagens" >
														<!--RECEBE TODAS AS IMAGEM VINDAS DA PESQUISA-->														
													</div>
													<div class="box_new_img">
														<div class="file-field input-field">
															<div class="btn">
																<span>Escolher Imagem <i>(jpg/png)</i></span><br/>
																<input type="file" name="imagem" id="add_new_img"/>
															</div>
														</div> 
													</div>
												</div>
											</div>															
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">											
											<label>Qual o(s) gênero(s) do seu jogo?</label><br/>
											<?php 												
												$dados = $generos->findAll();
												if(!empty($dados)):
													foreach ($dados as $chave => $info):																									
											?>
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-primary checkbox-genre">
													<label><input type="checkbox" name="genero[]" value="<?php echo $info->id;?>" autocomplete="off"><?php echo $info->nome;?></label>
													<span class="glyphicon glyphicon-ok"></span>
												</label>			
											</div>											
										    <?php
										    		endforeach;//final do foreach
										    	endif;
										    ?>										
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<label for="descricao">Descrição do jogo</label>
  											<textarea name="descricao" id="descricao" placeholder="Sua opinião sobre o jogo" class="form-control"></textarea>														
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">			
											<label for="infoExtra">Sobre o produto</label>
											<textarea name="infoExtra" id="infoExtra" placeholder="Algo sobre o produto. Ex - 2 anos de uso; capa riscada" class="form-control"></textarea>											
										</div>
										<!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<label>Escolher o jogo que deseja na troca?</label>
											<ul class="opcao-jogos">
											  <div class="arrow"></div>
											  <li class="radio-op" id="opnao">
											    <input name="opcao-escolha" type="radio" id="opnao" checked>
											    <label for="opnao"></label>
											  </li>

											  <li class="radio-op" id="opsim">
											    <input name="opcao-escolha" type="radio" id="opsim">
											    <label for="opsim"></label>
											  </li>				 
											</ul>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">										
											<div class="galeria">
												<nav>
													<ul class="box-galeria-jogos">			
														<?php								
															//foreach($console->listarTodos() as $valor):										
														?>
															<li name="<?php //echo strtoupper($valor->nome_console)?>" value="<?php //echo $valor->id_console?>" class="link"><?php //echo strtoupper($valor->nome_console)?></li>		 							
														<?php //endforeach; ?>
													</ul>
											   </nav>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<label for="minha-escolha">Jogo para troca</label>					
											<input type="text" name="jogo_troca" id="minha-escolha" placeholder="Jogo desejado" autocomplete="off" class="form-control">
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div id="container-second">
												<div class="deleteImg" id="delete_segunda_img"><img src="img/pop-botao-fecha.png" id="pop_botao_fecha"/></div>
												
												<div class="boximg" id="boxjogo_favorito"><!--RECEBE A IMAGEM DO JOGO</div>
												<div id="jogo_escolha" class="imagens"><!--RECEBE A IMAGEM DO JOGO ESPECÍFICA NA TROCA</div>
												<div class="box_new_img2">
													<div class="file-field input-field col-lg-8 col-md-6 col-sm-6">
												      <div class="btn">
												        <span>Escolher Imagem</span>
												        <input type="file" name="game" id="add_new_img2"/>
												      </div>		      
												    </div>
												</div>
											</div>
										</div>-->
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<p id="field_obrigatorio">Campos marcados com (*) são obrigatórios</p>
											<button id="btn-cancela" class="btn btn-danger btn-submit">Cancelar</button>
											<button type="submit" id="btn-cadastra" class="btn btn-success btn-submit">Cadastrar</button>
										</div>										
									</form>																	
								</div>								
							</div><!-- / .row -->
						</div>
					</div>	
				</div>
				<div class='alert alert-danger' id='msg_error'></div>					
			</div>

			<!--<div class="modal fade" id='modal_success' data-backdrop="false">
				<div class="modal-dialog">
					<div class="modal-content">
					    <div class="modal-body">
					        <div class="alert alert-success"><h3 id="myModalLabel" class="text-center"></h3></div>
					        <button id="confirm-record" class="btn btn-success">Confirmar</button>
					    </div>
					</div>
				</div>
			</div>-->
			
			<!--MODAL ATUALIZA OU DELETA JOGO-->
			<div class="modal fade" id="up_del_game">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h1 class="title_modal">Editar/Excluir jogo <i class="fa fa-gamepad fa-lg"></i></h1>
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

<script src="../js/funcoes.js" type="text/javascript"></script>
<script src="js/acoes.js" type="text/javascript"></script>
