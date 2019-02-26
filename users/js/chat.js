$(document).ready(function(){
    /*@param idlogado - id do user logado*/

    //pegar o contato
    $(".chat").on("click", function(){
        user = $(this).attr("usuario");
        chat_id = $(this).attr("id");
        separarId = chat_id.split("_");
        idUser = separarId[1];
        
        id = (idUser) ? idUser : 0;
        $("#idto").val(id);
        //idlogado = (idlogado) ? idlogado : 0;

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
                    $(".chat_begin").css("display", "block");
                }
                $(".mensagens #chat_msg").html(dados);
            }else{
                $(".mensagens #chat_msg").html("<span class='no_mensagem'>Não há mensagens para exibir</span>");
                $(".chat_begin").css("display", "none");
            }
        });
    });

    function enviarMensagem(campo, mensagem, to){
        if(mensagem !== '' && to !== ""){
            campo.val('');
            $.post('../controllers/chat.php', {
                acao : 'inserir',
                mensagem: mensagem,
                para: to
            }, function (retorno){
                $("#field-message").focus();
                setTimeout(function(){			
                    $('#chat_msg').append(retorno);						
                }, 1000);
            });
        }
		return false;
    }
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
		idReceiver = (idlogado) ? idlogado : '';
		//idReceiver = idReceiver.split('_')[1];//separar o ID do usuário
        
		$.post('../controllers/chat.php', {			
			acao: 'leitura',
			idPara : idReceiver
		}, function(back){
			console.log(back);
			// if(back.status == '1'){
			// 	//faça algo	
			// }
		}, 'jSON');		
	});
});