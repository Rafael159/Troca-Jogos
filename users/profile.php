<?php
    spl_autoload_register(function($classe) {
        require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');
    });
    session_start();
    $userID = (isset($_SESSION['id_user']) ? $_SESSION['id_user'] : '');

    $user = new Usuarios;
    $user->setIdUser($userID);
    $row = $user->findRegister();

?>
<div id="profile">
<div class="row nopadding">
    <div id="box" class="col-lg-12 col-md-12 col-sm-12">
        
        <div id="formulario-update">
            <div class="msgcrud"></div>
            <form method="POST" id="form-update" action="" class="form">	
                
                <div class="steps" id="first-step">
                    <h3 class="title_steps">Dados de acesso <i class="fa fa-address-card" aria-hidden="true"></i></i></h3>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="nome"><i class="fa fa-user fa-lg" aria-hidden="true"></i> Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" value=""/>
                            <input type="hidden" name="email" id="email"/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="email"><i class="fa fa-envelope fa-lg"></i> Email</label>
                                <input type="text" name="emailblock" id="emailblock" value="<?php echo ($row->emailTJ) ? $row->emailTJ : ''?>" class="form-control" disabled/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="celular"><i class="fa fa-mobile fa-lg"></i> Celular</label>
                            <input type="text" name="celular" id="celular" class="form-control" value=""/>
                        </div>	
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="telefone"><i class="fa fa-phone fa-lg"></i> Telefone</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" value=""/>
                        </div>										 
                        <!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="senha"><i class="fa fa-key fa-lg"></i> Senha</label>
                            <input type="password" name="senha" id="senha" class="form-control"/>
                        </div>-->
                        <!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="conf-senha"><i class="fa fa-key fa-fw"></i> Confirmar senha</label>
                            <input type="password" name="conf_senha" id="conf_senha" placeholder="Confirmar Senha" class="form-control"/>										
                        </div>-->																			
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
                            <input type="text" name="numero" id="numero" placeholder="Número" class="form-control"/>
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
                            <input type="text" name="complemento" id="complemento" placeholder="Complemento" class="form-control"/>
                        </div>
                        <div id="retorno"></div><!--recebe a mensagem de erro-->

                        <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">                            
                            <div class="alert alert-danger fail">
                                <strong></strong>
                            </div>
                            <div class="btn-group">                                	
                                <button type="submit" name="btnUpdate" class="btn btn-success" id="btnUpdate">Atualizar</button>	
                            </div>										
                        </div>
                    </div>	
                </div><!--/ fim da third step-->							
            </form><!--fim form de cadastro -->	
        </div>	<!-- / fim formulário-->	
    </div>
</div>
</div>
<script
  src="https://code.jquery.com/jquery-3.4.0.js"
  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
  crossorigin="anonymous"></script>
<script src="../js/jquery.validate.js" type="text/javascript"></script>
<script src="../js/jquery.mask.js" type="text/javascript"></script>
<script src="js/profile.js" type="text/javascript"></script>
<script src="..\bootstrap/js/bootstrap.min.js"></script>


<script>
    var form_values = {}

    form_values.nome = "<?php echo (isset($row->nomeUser)) ? $row->nomeUser : '' ?>";
    form_values.email = "<?php echo (isset($row->emailTJ)) ? $row->emailTJ : '' ?>";
    form_values.celular = "<?php echo (isset($row->celular)) ? $row->celular : '' ?>";
    form_values.telefone = "<?php echo (isset($row->telefone)) ? $row->telefone : '' ?>";
    form_values.console = "<?php echo (isset($row->console)) ? $row->console : '' ?>";
    form_values.cep = "<?php echo (isset($row->cep)) ? $row->cep : '' ?>";
    form_values.rua = "<?php echo (isset($row->rua)) ? $row->rua : '' ?>";
    form_values.numero = "<?php echo (isset($row->numero)) ? $row->numero : '' ?>";
    form_values.bairro = "<?php echo (isset($row->bairro)) ? $row->bairro : '' ?>";
    form_values.cidade = "<?php echo (isset($row->cidade)) ? $row->cidade : '' ?>";
    form_values.estado = "<?php echo (isset($row->estado)) ? $row->estado : '' ?>";
    form_values.complemento = "<?php echo (isset($row->complemento)) ? $row->complemento : '' ?>";
   
</script>