$(document).ready(function(){

	/***Atualizar jogo***/
	$('#btnAtualiza').bind("click", function(e){
		e.preventDefault();

		// Captura os dados do formulário
		var formulario = document.getElementById('update_jogo');		
		// Instância o FormData passando como parâmetro o formulário
		var formData = new FormData(formulario);

		// Envia O FormData através da requisição AJAX
		$.ajax({
		   url: "update.php",
		   type: "POST",
		   data: formData,
		   dataType: 'json',
		   processData: false,  
		   contentType: false,
		   success: function(dados){
		   		/*0 => erro  <--> 1 => sucesso*/
		   		if(dados.flag == '0'){
		   			$("#msg_update").css("background-color","#c01a1a").html(dados.mensagem).fadeIn();
		   			setTimeout(function(){
						$('#msg_update').fadeOut();//esconder div de erro depois de 3s
	   				},3000);				
		   		}else{		   					
					$('#up_del_game').modal("toggle");
		   			setTimeout(function(){						
						$('#feedback_message').fadeIn();
						$('#feedback_message #message').html(dados.mensagem);						 				
	   				},1000); 							
		   		}
	   	    }
		});
	});/*FIM DO ATUALIZAR JOGO*/
	
	$('#btnCancelaDelete').bind('click', function(){
		$('#confirm-delete').fadeOut('fast', function(){
			$('#btn_group').fadeIn();
		});	
	});

	$('#buttonApagar').bind('click', function(){
		$('#btn_group').fadeOut('fast', function(){
			$('#confirm-delete').fadeIn();
		});	
	});

	/*APAGAR JOGO*/
	$('#btnDeleta').bind('click', function(ev){
		ev.preventDefault();

		var id =  $(this).attr('name'); //recupera o id da imagem
		$.ajax({
			url:     'excluir_jogo.php',
			type:    'post',
			data:    'id='+id,
			dataType:'json',

			success:function(retorno){						
				if(retorno.status == '0'){
					$("#msg_update").css("background-color","#c01a1a").html(retorno.mensagem).fadeIn();
				}else{	
					qnt = $('#jogos .badge').text();
			   		qnt = parseInt(qnt) - 1;//add 1
	   				$('#jogos .badge').text(qnt);/*atualizar quantidade de jogos temporariamente*/

					$('#up_del_game').modal('toggle');				
					setTimeout(function(){						
						$('#feedback_message').fadeIn();
						$('#feedback_message #message').html(retorno.mensagem); 				
	   				},1000);					
				}	
			}
		});
	});
});