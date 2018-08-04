$(document).ready(function(){

/*
* Função: Mostrar mensagens
* @param msg - mensagem que será exibida
*/
function message(msg){
	var body = $("html, body");
	body.stop().animate({scrollTop:0}, '500', 'swing', function() { 
	   body.css({"overflow-y":"hidden"});
	   $('.overlay').fadeIn('fast',function(){
			$('#msg').fadeIn().animate({top:'5%'});
			$('#msg span').html(msg);							
	    });						 
	});

	setTimeout(function(){
		$('#msg').animate({top:'-30%'}).fadeOut('fast',function(){
			$('.overlay').fadeOut();
			body.css({"overflow-y":"visible"});
		});								
	},3000);
}

function MaisMenos(){
	$("#txtValor").attr("disabled",false);
	$("span#quadroOpcao ").css({"visibility":"visible"});
	$("#txtValor").val("");	
}
/*CONFIGURAÇÃO INICIAL ANTES DE ENVIAR A PROPOSTA*/
$("#igualVale").parent().parent().addClass("type_active");//ativar o botão EQUILIBRADO
$("span#quadroOpcao ").css({"visibility":"hidden"});//esconder o campo para inserção de valores

$('.btn-opcao').change(function(){
	//remover class ativo onde estiver
	$('#fieldTroca .avalia-metodo').each(function(key, value){
		if($(this).hasClass('type_active')){
			$(this).removeClass('type_active');
		}
	});

	$(this).parent().parent().addClass("type_active");//add class ativo no atual
	
	var escolha = $(this).val();//pegar a descrição da opção escolhida	
	//alert(escolha);			
	switch (escolha){
		case '0':							
			MaisMenos();//chama função com algumas configurações												
		break;
		case '1':							
			$("#txtValor").attr("disabled",true);
			$("#txtValor").val('0');
			$("span#quadroOpcao ").css({"visibility":"hidden"});
		break;
		case '2':							
			MaisMenos();//chama função com algumas configurações											
		break;
	}
});

//cancelar operação
$('#btnCancelaTroca').click(function(){
	$('#boxOpcao').animate({ //mostrar e animar o quadro de opções
			top:'-10%'
		}).fadeOut('fast',function(){
			$('.overlay').fadeOut('slow');
			$('html, body').css({
				'overflow':'visible'
			});
		});
	$('#msg').html('');
});

/*ABRIR TELA DOS JOGOS DO USUÁRIO*/
$(".jgVelho").click(function(){
	$('html, body').animate({scrollTop:0}, 'slow',function(){
		$('html, body').css({
			'overflow':'hidden'
		});
	});	
	$('.overlay').fadeIn('fast',function(){
		$('#box_meu_jogo').fadeIn();
	});
});

/*FECHAR TELA*/
$("#close_pop_up").click(function(){
	$('html, body').animate({scrollTop:0}, 'slow',function(){
		$('html, body').css({
			'overflow':'visible'
		});
	});	
	$('#box_meu_jogo').fadeOut('slow', function(){
		$('.overlay').fadeOut();
	});
});

//CADASTRAR TROCA DE JOGO
	$('#btnConfirmar').bind('click', function(e){
		e.preventDefault();
		//RECUPERAR VALORES
		frm = $('#frm_trocas');
			//ENVIAR DADOS PARA SEREM GRAVADOS					
		$.ajax({
			type:'post',
			url:'troca.php',
			dataType: 'json',
			data: frm.serialize(),
			success: function(dados){
				if (dados.status == '0') {
					message(dados.mensagem);
				}else{
					message(dados.mensagem);
					setTimeout(function(){
						window.location.href = "../users/dashboard.php?secao=trocas";
					},3000);
				}
			}
		});
	});	
});