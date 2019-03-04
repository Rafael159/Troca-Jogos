$(function(){

	function control_chat(){
		$('.chat .chat-content').toggle();
	}
	function scrollDown(){
		//var divMensagens = $('.chat-content');
		//var height = divMensagens.scrollHeight;
		//posicao = $(".msgs:last-child").offset().top;
		pos = $('.chat-content').position().top;

		 $(".mensagens").animate({ 
	      scrollTop: $( $('.msgs:last-child') ).offset().top 
	    }, 3000);

		return false;
	}


	$('.chat-title, .auth-message').on('click', function(){
		control_chat();
		//scrollDown();
	});	

	$('body').delegate('#field-message', 'keydown', function(e){

		var campo = $(this);
		var mensagem = campo.val();
		var to = campo.prev().attr('id');
		
		idTo = to.split('_')[1];//separar o ID do usuário
		//$(this).disabled();

		if(e.keyCode == 13){
			if(mensagem != ''){
				campo.val('');
				$.post('controllers/chat.php', {
					acao : 'inserir',
					mensagem: mensagem,
					para: idTo
				}, function (retorno){
					
					// setTimeout(function(){						
					// 	$('.mensagens').append(retorno);						
					// }, 3000);
					//scrollDown();
				});
			}
			return false;
		}	
		return true;
		
	});

	$('#field-message').focus(function(){

		idReceiver = $('.mensagens').attr('id');
		idReceiver = idReceiver.split('_')[1];//separar o ID do usuário

		$.post('controllers/chat.php', {			
			acao: 'leitura',
			idPara : idReceiver

		}, function(back){
			if(back.status == '1'){
				//faça algo
			}
		}, 'jSON');		
	});

	function firstLoad(){
		idReceiver = $('.mensagens').attr('id');
		idReceiver = idReceiver.split('_')[1];//separar o ID do usuário

		$.post('controllers/chat.php', {			
			acao: 'atualizar',
			idPara : idReceiver

		}, function(back){			
			
			if(back != ''){
				control_chat();
				$('.mensagens').html(back);
				scrollDown();
			}else{
				$('.mensagens').html('Seja o primeiro a mandar uma mensagem');
			}
		},'jSON');
	}

	firstLoad();
	
	// setInterval(function(){
	// 	idReceiver = $('.mensagens').attr('id');
	// 	idReceiver = idReceiver.split('_')[1];//separar o ID do usuário
		
	// 	$.post('controllers/chat.php', {			
	// 		acao: 'atualizar',
	// 		idPara : idReceiver
	// 	}, function(back){
	// 		if(back != ''){	
	// 			//scrollDown();
	// 			$('.mensagens').html(back);
	// 		}else{
	// 			$('.mensagens').html('Seja o primeiro a mandar uma mensagem');
	// 		}
	// 	},'jSON');

	// },3000);

	/** 
	 * Função: enviar convite
	 * @param obj - botão clicado
	 * @id_send - remetente do convite
	 * @id_receive - destinatário do convite
	*/

	function addFriend(idsend, idreceiver){
		$.post('controllers/convites.php', {			
			acao: 'enviar',
			idsend : idsend,
			idreceiver: idreceiver
		}, function(back){
			if(back.status==="1"){
				$("#alerta-msg").addClass("alert-success").html("Amigo adicionado com sucesso. Aguarde confirmação").fadeIn();
				$(".friend-title").html("Convite enviado");
			}else{				
				$("#alerta-msg").addClass("alert-danger").html("Houve um erro ao adicionar amigo").fadeIn();
			}

			setTimeout(function(){
				$("#alerta-msg").fadeOut('fast');
			}, 5000);
		}, "jSON");

	}
	$("#invite").on("click", function(ev){
		ev.preventDefault();
		idsend = $("#idon").val();
		idreceiver = $("#coduser").val();

		addFriend(idsend, idreceiver);
	});
});