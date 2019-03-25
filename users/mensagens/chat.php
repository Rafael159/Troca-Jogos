<?php
    //@BD::conn();//conexão com o banco de dados
    
    function __autoload($classe){
		require('../../classes/'.$classe.'.class.php');
    }
    $user = new Usuarios();
    $friends = new Friendships();
?>

<link rel="stylesheet" type="text/css" href="css/chat.css"/>
<link rel="stylesheet" type="text/css" href="../css/fonts.css"/>

<div class="row nopadding">
    <div class="col-lg-12 nopadding">
        <div class="main">
            <div class="panels" id="leftpanel">
                <div class="col-lg-1 col-lg-push-3">
                    <!-- <div class="settings">
                        <div class="setting" id="remove-confirm">
                            <i class="fa fa-trash fa-2x"></i>
                            <div id="box_excluir">
                                <span>Tem certeza que deseja excluir a conversa?</span><br>
                                <div class="btn-group">
                                    <button class="btn btn-danger" id="excluir_no">Não</button>
                                    <button class="btn btn-success" id="excluir_yes">Sim</button>
                                </div>
                            </div>                           
                        </div>
                         <div class="setting"><i class="fa fa-cog fa-2x" aria-hidden="true"></i></div>
                        <div class="setting"><i class="fa fa-tachometer fa-2x"></i></div>
                    </div>                     -->
                </div>
                <div class="col-lg-8 col-lg-push-3 nopadding">
                    <div class="chat-content">
                        <div class="mensagens" id="jan_">
                            <i class="chat_begin">Inicio da sua conversa com <span id="talkto"></span></i> 
                            <label class="chat_warning">Clique em um contato para iniciar uma conversa</label>                            
                            <div id="chat_msg"></div>
                        </div>
                        <div class="box_form">
                            <form name="chat_form" id="chat_form">
                                <input type="hidden" name="idto" id="idto">
                                <input type="text" name="msg" placeholder="Digite sua mensagem" id="field-message" autocomplete="off"/>
                                <button id="btn_send">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="panels" id="rightpanel">
                <div id="chats">
                    <span class="amigos-titulo">Contatos</span>
                    <ul class="chat_holder">
                        <?php
                            $iduser = Usuarios::getUsuario('id_user');//ID logado
                            $row = Friendships::getFriendsHelper(array('who_sent'=>$iduser));                   
                            
                            if(count($row) > 0):
                                foreach($row as $list):
                                    $usuario = ($iduser == $list->who_sent) ? $list->who_accepted : $list->who_sent;

                                    foreach(Usuarios::getRegisterHelper(array('id'=>$usuario)) as $k => $v):
                                        if($iduser != $v->id_user):
                            ?>
                                <li class="chat" id="chat_<?php echo $v->id_user?>" usuario="<?php echo $v->nomeUser; ?>"><div class="content"><span class="contact_name"></span><?php echo $v->nomeUser; ?> - <span class="contact_consola"><?php echo strtoupper($v->nome_console)?></span><span class="msgnotread"><?php echo Mensagens::countMensagens(array('cod_from'=>$v->id_user, 'cod_to'=>$iduser, 'lido'=>'nao'))?></span></div></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="contato-alerta">Ops :( <br>
                            Nenhum contato para exibir<br><br><br>
                            Para adicionar um contato, vá até o perfil do contato e clique em adicionar contato ou mande uma mensagem
                            </span>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/chat.js"></script>
<script>
    var idlogado = "<?php echo ($iduser) ? $iduser : ""?>";
</script>