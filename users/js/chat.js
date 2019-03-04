$(document).ready(function(){
    /*@param idlogado - id do user logado*/
    function enviarMensagem(campo, mensagem, to){
        if(mensagem !== '' && to !== ""){
            campo.val('');
            $.post('../controllers/chat.php', {
                acao : 'inserir',
                mensagem: mensagem,
                para: to
            }, function (retorno){
                $("#field-message").focus();
                //setTimeout(function(){		
                    $('#chat_msg').append(retorno);
                //}, 1000);
            });
        }
		return false;
    }
    function atualizaChat(){
        setTimeout(function(){
            para = $("#idto").val();
            
            $.ajax({
                method:'POST',
                url: '../controllers/chat.php',
                dataType: 'json',
                data: {
                    idPara: para,
                    acao: 'atualizar'
                },
                success: function(dados){
                    if(dados != ''){
                        $(".no_mensagem").fadeOut();
                        $('#chat_msg').html(dados);
                        atualizaChat();
                    }
                    // else{
                    //     $('#chat_msg').html('Seja o primeiro a mandar uma mensagem');
                    // }
                }
            });      
        },3000);
    }
    function removeChat(de, para){
        alert(de, para);
        $.ajax({
            method:'POST',
            url: '../controllers/chat.php',
            dataType: 'html',
            data: {
                de: de,
                para: para,
                acao: 'excluir'
            }
        }).done(function(dados){
            console.log(dados);
        });
        
    }
    $("#remove-confirm").on("click", function(){

    });

    $("#excluir_yes").on("click", function(){
        para = $("#idto").val();
        idlogado = (idlogado) ? idlogado : '';

        removeChat(idlogado, para);
    });

    //pegar o contato
    $(".chat").on("click", function(){
        user = $(this).attr("usuario");
        chat_id = $(this).attr("id");
        separarId = chat_id.split("_");
        idUser = separarId[1];
        
        id = (idUser) ? idUser : 0;
        $("#idto").val(id);
        
        $.ajax({
            method:'POST',
            url: '../controllers/chat.php',
            data: {
                para: id, 
                acao: 'get'
            }
        }).done(function(dados){
            if(dados !== ""){
                if(user){
                    $("#talkto").html(user);
                    $(".chat_warning").css("display", "none");
                    $(".chat_begin, .box_form, .settings").css("display", "block");
                }
                $(".mensagens #chat_msg").html(dados);
                atualizaChat();
            }else{
                $(".chat_warning, .chat_begin").css("display", "none");
                $(".mensagens #chat_msg").html("<span class='no_mensagem'>Não há mensagens. Inicie uma conversa agora mesmo</span>");
            }
        });
    });
    
    
    $("#btn_send").on("click", function(ev){
        ev.preventDefault();
        
        var campo = $("#field-message");
		var mensagem = campo.val();
        var to = $("#idto").val();
        enviarMensagem(campo, mensagem, to);
    });

    $('body').delegate('#field-message', 'keydown', function(e){
		var campo = $(this);
		var mensagem = campo.val();
        var to = $("#idto").val();
        if(e.keyCode == 13){
            enviarMensagem(campo, mensagem, to);
        }		
    });
    
    $('#field-message').focus(function(){
        para = $("#idto").val();
        
        $.ajax({
            method:'POST',
            url: '../controllers/chat.php',
            dataType: 'json',
            data: {
                para: para, 
                acao: 'leitura'
            }
        }).done(function(dados){
            if(dados.status === '1'){
                $("#chat_"+para+" .content .msgnotread").html("0");
            }
        });
    });
    
});