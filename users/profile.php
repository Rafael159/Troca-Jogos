
<link rel="text/stylesheet" type="text/css" href="css/style-profile.css">

<div id="profile">
<div class="row nopadding">
    <div id="box" class="col-lg-12 col-md-12 col-sm-12">
        
        <div id="formulario-update">                            
            <form method="POST" id="form-cadastro" action="" class="form">	
                
                <div class="steps" id="first-step">
                    <h3 class="title_steps">Dados de acesso <i class="fa fa-address-card" aria-hidden="true"></i></i></h3>
                    <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="nome"><i class="fa fa-user fa-lg" aria-hidden="true"></i> Nome</label>
                            <input type="text" name="nome" id="nome" placeholder="Nome" class="form-control"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="email"><i class="fa fa-envelope fa-lg"></i> Email</label>
                                <input type="text" name="email" id="email" placeholder="Email" value="<?php if(isset($email)){echo $email;}else{};?>" class="form-control"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="celular"><i class="fa fa-mobile fa-lg"></i> Celular</label>
                            <input type="text" name="celular" id="celular" placeholder="Celular" class="form-control"/>
                            </div>	
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="telefone"><i class="fa fa-phone fa-lg"></i> Telefone</label>
                            <input type="text" name="telefone" id="telefone" placeholder="Telefone (opcional)" class="form-control"/>
                            </div>										 
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="senha"><i class="fa fa-key fa-lg"></i> Senha</label>
                            <input type="password" name="senha" id="senha" placeholder="Senha" value="<?php if(isset($senha)){echo $senha;}else{};?>" class="form-control"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="conf-senha"><i class="fa fa-key fa-fw"></i> Confirmar senha</label>
                            <input type="password" name="conf_senha" id="conf_senha" placeholder="Confirmar Senha" class="form-control"/>										
                        </div>																			
                    </div>									
                </div>
                <div class="steps" id="second-step">	
                    <h3 class="title_steps">Qual video game você possui ou tem mais interesse? <i class="fa fa-gamepad" aria-hidden="true"></i></h3>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <select id="console" class="form-control" name="console" class="required">
                                <option value="">Seu console</option>												
                            </select>
                        </div>
                    </div>													
                </div><!--/ fim do second step-->
                
                <div class="steps" id="third-step">
                    <h3 class="title_steps">Dados de entrega <i class="fa fa-paper-plane" aria-hidden="true"></i> <i>(opcional)</i> </h3>
                    <div class="row">				
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="rua">CEP</label>
                                <input type="text" name="cep" id="cep" placeholder="CEP" class="form-control"/>
                                <small id="erro_cep"></small>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="rua">Rua</label>
                                <input type="text" name="rua" id="rua" placeholder="Rua" class="form-control"/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="numero">Número</label>
                            <input type="text" name="numero" id="numero" placeholder="Número" pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$" class="form-control"/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="bairro">Bairro</label>
                            <input type="text" name="bairro" id="bairro" placeholder="Bairro" class="form-control"/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="cidade">Cidade</label>
                            <input type="text" name="cidade" id="cidade" placeholder="Cidade" class="form-control"/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="estado">Estado</label>
                            <select type="text" name="estado" id="estado" class="form-control">
                                <option value="">Estado</option>																				
                            </select>									
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="comple">Complemento</label>
                            <input type="text" name="comple" id="complemento" placeholder="Complemento" class="form-control"/>
                        </div>
                        <div id="retorno"></div><!--recebe a mensagem de erro-->

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <section class="information"><a href="#" id="linkExplica" data-toggle="modal" data-target="#show-reason">Por que informar o endereço?</a></section>
                        </div>
                        <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">                            
                            <div class="alert alert-danger" id='msg_error'>
                                <strong></strong>
                            </div>
                            <div class="btn-group">                                	
                                <button type="submit" name="btnUpdate" class="btn btn-success" id="btnUpdate">Atualizar</button>	
                            </div>										
                        </div>
                    </div>	
                </div><!--/ fim da third step-->							
            </form><!--fim form de cadastro -->	
        </div>	<!-- / fim id formulário-->	
    </div>
</div>
</div>
<script src="js/profile.js" type="text/javascript"></script>