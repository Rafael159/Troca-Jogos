<?php
    //@BD::conn();//conexão com o banco de dados
    
    function __autoload($classe){
		require('../../classes/'.$classe.'.class.php');
    }
    $user = new Usuarios();
    $friends = new Friendships;
?>

<link rel="stylesheet" type="text/css" href="css/chat.css"/>

<div class="row nopadding">
    <div class="col-lg-12 nopadding">
        <div class="main">
            <div class="panels" id="leftpanel">
                <div class="col-lg-1 col-lg-push-3">
                    <div class="settings">
                        <div class="setting"><i class="fa fa-tachometer fa-2x"></i></div>
                        <div class="setting"><i class="fa fa-cog fa-2x" aria-hidden="true"></i></div>
                        <div class="setting"><i class="fa fa-tachometer fa-2x"></i></div>
                    </div>
                </div>
                <div class="col-lg-8 col-lg-push-3 nopadding">
                    <div class="chat-content">
                        <div class="mensagens" id="jan_">
                            <i class="chat_begin">Inicio da sua conversa com <span id="talkto"></span></i> 
                            <div id="chat_msg"></div>
                            <!-- <div class="msg-from msgs">Então, sobre o jogo, estou afim de trocarEntão, sobre o jogo, estou afim de trocarEntão, sobre o jogo, estou afim de trocar</div>
                            <div class="msg-from msgs">Ainda tem o Raibow Six 6?</div>
                            <div class="msg-to msgs">Tenho sim brow</div>
                            <div class="msg-from msgs">Perfeito. Você aceita o RE2 como troca?</div>
                            <div class="msg-to msgs">RE2 é o Resident né?</div>
                            <div class="msg-to msgs">Se for, demorou. Bora trocar</div>
                            <div class="msg-from msgs">Ainda tem o Raibow Six 6?</div>
                            <div class="msg-to msgs">Tenho sim brow</div>
                            <div class="msg-from msgs">Perfeito. Você aceita o RE2 como troca?</div>
                            <div class="msg-from msgs">Ainda tem o Raibow Six 6?</div>
                            <div class="msg-to msgs">Tenho sim brow</div>
                            <div class="msg-from msgs">Perfeito. Você aceita o RE2 como troca?</div> -->
                        </div>
                        <div class="box_form">
                            <form method="post" name="chat_form" id="chat_form">
                                <input type="text" name="msg" placeholder="Digite sua mensagem" id="field-message" autocomplete="off"/>
                                <button onclick="send()" id="btn_send">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="panels" id="rightpanel">
                <div id="chats">
                    <ul class="chat_holder">
                        <?php                            
                            $row = $friends->getFriends();
                            $iduser = Usuarios::getUsuario('id_user');//ID logado
                            
                            foreach($row as $list):
								foreach(Usuarios::getRegisterHelper(array('id'=>$list->who_accepted)) as $k => $v):
						?>
                            	<li class="chat" id="chat_<?php echo $v->id_user?>" usuario="<?php echo $v->nomeUser; ?>"><div class="content"><span class="contact_name"></span><?php echo $v->nomeUser; ?> - <span class="contact_consola"><?php echo strtoupper($v->nome_console)?></span><span class="msgnotread"><?php echo Mensagens::countMensagens(array('cod_from'=>$v->id_user, 'cod_to'=>$iduser, 'lido'=>'nao'))?></span></div></li>
                        	<?php endforeach; ?>
                        <?php endforeach; ?>
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