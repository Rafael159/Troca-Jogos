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
	    }, 600);

		return false;
		//alert(pos);	
			/*var scrollIndex = $('.msgs:last-child').offset();*/
		//$(".mensagens").animate({scrollTop:(pos)},500);
		
		//var offset = $('.msgs:last-child').offset();
		/*$('.mensagens').animate({ 
			scrollTop: $('span[name=lastMessage]').offset().top
		}, 1000);*/

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
					
					setTimeout(function(){						
						$('.mensagens').append(retorno);						
					}, 500);
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
			console.log(back);
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
	
	setInterval(function(){
		idReceiver = $('.mensagens').attr('id');
		idReceiver = idReceiver.split('_')[1];//separar o ID do usuário
		
		$.post('controllers/chat.php', {			
			acao: 'atualizar',
			idPara : idReceiver

		}, function(back){
			console.log(back);
			if(back != ''){	
				//scrollDown();
				$('.mensagens').html(back);
			}else{
				$('.mensagens').html('Seja o primeiro a mandar uma mensagem');
			}
		},'jSON');

	},2000);
});