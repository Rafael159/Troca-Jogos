$(document).ready(function(){
    /*@param to - id do user logado*/
    function enviarMensagem(campo, mensagem, to){
        mensagem = $.trim(mensagem);
        if(mensagem !== '' && to !== ""){
            campo.val('');
            $.post('../controllers/chat.php', {
                acao : 'inserir',
                mensagem: mensagem,
                para: to
            }, function (retorno){
                $("#field-message").val('');
                $("#field-message").focus();		
                $('#chat_msg').append(retorno);
            });
        }else{            
            $('#field-message').focus(function() {
                $(this).val('');
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
            //console.log(dados);
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
        if($(this).hasClass("chosen")){
            //não fazer nada se for clicado no chat já selecionado
        }else{
            $(".chat_holder .chat").each(function(){
                if($(this).hasClass("chosen")){
                    $(this).removeClass("chosen");
                }
            });
            $(this).addClass("chosen");

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
                $("#chat_form").show();
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
                    $(".mensagens #chat_msg").html("<span class='no_mensagem'>Inicie uma conversa agora mesmo</span>");
                }
            });
        }
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

    $("#field-message").keyup(function(e){
        var len = this.value.length;
        if (len >= 200) { //VERIFICA SE TEM MAIS DE 350 CARACTERES
            this.value = this.value.substring(0, 200);
        }
        //$j('#resta').text(350 - len); //EXIBE OS CARACTERES RESTANTES
        
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