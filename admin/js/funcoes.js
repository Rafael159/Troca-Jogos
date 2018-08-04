$(document).ready(function(e){

	/*
	 * PÁGINA COM AS AÇÕES E ANIMAÇÕES DA PÁGINA ADMIN.PHP 
	 */
	 $("#esquerda .mn_admin li").click(function(e){ // quando clicar em uma opção
		e.preventDefault();
		
		if($(this).hasClass("actived")){
			$(this).removeClass("actived");
		}else{			
			$("#esquerda .mn_admin li").each(function(i){
				$("li:not(actived)").removeClass("actived");
			});
			alert('ok');
  			var href = $(this).find('a').attr('href');//recupera href clicado		  			  		
			//verificar se já está ativo
			$(this).addClass("actived");
			$("#conteudo_principal").load(href + "#conteudo_principal");		
		}
	});


	$("#confirmar-btn").click(function(){
		$("#msg").animate({
			top:'-50%'
		}, function(){
			$("#msg").fadeOut();
			$(".overlay").fadeOut();
		});
	});
	/*TELA DE MENSAGENS*/
	function mensagem(titulo, msg){
		$(".overlay").show();
		$("#msg header").html(titulo);
		$("#msg span").html(msg);
		$("#msg").fadeIn().animate({
			top:'15%'
		});			
	}

	$("#btn-config").click(function(){
		$("#box-config").fadeIn();//MOSTRAR AS OPÇÕES PARA CADASTRAR IMG'S					
	});

	/*CHAMA A TELA DE CADASTRO DE IMAGENS*/
	$("#btn-add-img").click(function(){
		var href = 'cadastro_imagem.php';
		$("#conteudo_principal").load(href + "#conteudo_principal");
	});

	
	function acaoimagem(){
		/*MOSTRAR OPÇÕES DA IMAGEM*/
		$(".box_imagens .each-img").mouseenter(function(){					
			$(this).find(".box-opcao").fadeIn();
		});
		/*ESCONDER OPÇÕES IMAGEM*/
		$(".box_imagens .each-img").mouseleave(function(){					
			$(this).find(".box-opcao").fadeOut();
		});

		/*DELETAR IMAGEM*/
		$(".icon-deletar").click(function(){
			var id = $(this).parent().parent().attr('id'); //recupera o id da imagem
			$(".alert-overlay").fadeIn();	

			/*levar a página para o topo e remover o scroll da página*/
			var body = $("html, body");
			body.stop().animate({scrollTop:0}, '500', 'swing', function() { 
			   body.css({"overflow-y":"hidden"});						 
			});

		    $("#box_confirmacao").fadeIn();	//mostra a caixa de confirmação
		    $('#recuperaId').val(id); //coloca o ID em um input para ser pego depois
		});

		/*ATUALIZAR O NOME DA IMAGEM*/
		$(".icon-editar").click(function(){
			var jogo = $(this).parent().parent().parent().find(".nm_jogo").val(); //recupera nome do jogo
			var id = $(this).parent().parent().attr('id'); //recupera o id da imagem

			$.post('atualiza_img.php',{ //envia para a página de exclusão
				id:id,jogo:jogo,
			}, function(retorno){

				if(retorno != ''){ //se houver erro, mostre
					mensagem('Erro ao atualizar imagem!','Ocorreu um erro.Tente mais tarde');
				}else{	//senão, atualiza a página
					$("#conteudo_principal").slideUp('slow', function(){
						$("#conteudo_principal").load('imagens.php' + "#conteudo_principal",function(){
							$("#conteudo_principal").slideDown('fast');
						});
					});
																
				}								
			});
		});
	}
	acaoimagem();//CONFIGURA O EFEITO NAS IMAGENS CARREGADAS
	
	$(".alert-btn").click(function(){						
			var acao = $(this).attr("name"); //recupera a ação desejada
			switch (acao){
				case 'confirma': //se confirmar
					var id =  $('#recuperaId').val(); //recupera o id da imagem
					$.post('excluir_img.php',{ //envia para a página de exclusão
						id:id,
					}, function(retorno){
						if(retorno == ''){ //se houver erro, mostre
							mensagem('Erro ao excluir imagem!','Algum erro ocorreu, tente mais');
						}else{	//senão, atualiza a página
							var href = 'imagens.php'; 
							$("#conteudo_principal").load(href + "#conteudo_principal");
						}								
					});
				break;
				case 'cancela':
					$("#box_confirmacao").fadeOut();//esconde a caixa de confirmação
					$(".alert-overlay").fadeOut();

					$("html,body").css({"overflow-y":"visible"});	
				break;
				default:
					$("#box_confirmacao").fadeOut();//esconde a caixa de confirmação
					$(".alert-overlay").fadeOut();	
		}
	});


	/*FILTRO POR CONSOLE*/
	$(".mn-console ul li").click(function(){
		if($(this).hasClass("actived")){
			$(this).removeClass("actived");
			$("#conteudo_principal").load('imagens.php' + "#conteudo_principal");
		}else{
			var id = $( this ).attr("id");

			$(".mn-console ul li").each(function(i){
				$("li:not(actived)").removeClass("actived");
			});
			
			$(this).addClass("actived");
			
			$.post('filtro.php',{id:id},function(dados){
				$(".box_imagens").html(dados);
				acaoimagem();
			});
		}
	});
/*
 * EFEITOS E FUNÇÕES RELACIONADAS A PÁGINA CADASTRAR IMAGEM 
 */
/*	CONFIGURAÇÃO INICIAL
	BOTÃO BLOQUEADO
	SOMENTE PRIMEIRA PARA VISÍVEL
*/
/*Efeito nos detalhes do jogo*/
$(".quadro-galeria:first-child").fadeIn();		

function btn_selected(){
	$(".galeria .box-galeria-jogos li").click(function(){

		$(".galeria .box-galeria-jogos li").each(function(i){ //destacar o console clicado
			$( "li:not(actived)").removeClass("actived");
		});
		$(this).addClass("actived");
		/*recebe o link que será mostrado*/			
	});
}
btn_selected();
/*INICIO DO CADASTRO DA IMAGEM*/				
/*PRIMEIRA PARTE*/
$(".section:first-child").show(); //mostrar a primeira parte

$("#confirmar-btn").click(function(){
	$("#msg").animate({
		top:'-50%'
	}, function(){
		$("#msg").fadeOut();
		$(".overlay").fadeOut();
	});
});

/*TELA DE MENSAGENS*/
function mensagem(titulo, msg){
	$(".overlay").show();
	$("#msg header").html(titulo);
	$("#msg span").html(msg);
	$("#msg").fadeIn().animate({
		top:'15%'
	});			
}
/*FAZER O CADASTRO DA IMAGEM*/		
$("#console-btn").click(function(){	
	var cont = 0;		
	$(".galeria .box-galeria-jogos li").each(function(i){				
		if($(this).hasClass("actived")){	
			var id = $(this).val();		
			$("#id-console").val(id);	
			cont = cont+1;
		}				
	});
	//VERIFICAÇÃO SE ALGUM CONSOLE FOI CLICADO
	if(cont != 0){	
		$("#box_console").fadeOut('slow',function(){
			$("#box_nome").fadeIn('fast'); //mostrar quadro do cadastro de imagem
		});
	}else{					
		mensagem('Confirmação de cadastro','Selecione o console');					
		}
				
});

/*SEGUNDA PARTE*/
$("#nome-jogo-btn").click(function(){
	var nome = $('#txt-jogo').val();
	if(nome == ''){
		mensagem('Erro!','Informe o nome do jogo');
	}else{				
		$("#nome-jogo").val(nome);
		$("#box_nome").fadeOut('slow',function(){
			$("#box_imagem").fadeIn('fast'); //mostrar quadro do cadastro de imagem
		});
	}
});	


/*TERCEIRA PARTE*/
$('#arquivo').change(function(){ //quando a imagem for chamada
	$("#upload_form").submit(); //envia um sinal para o form submeter
});
$("#upload_form").on('submit',(function(e) { //faz o upload 
	e.preventDefault();
	
	$.ajax({
    	url: "processa.php",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
	    cache: false,
		processData:false,
		dataType: 'json',
		success: function(data)
	    {			    	
	    	if(data.sucesso == true){
				$("#output").html("<img src='"+data.nome+"'>"); //mostrar imagem
				$("#nome-imagem").val(data.nomeAleatorio);
			}else{
				mensagem('Erro na requisição',data.erro);
			}
	    },	    
	  	error: function() 
    	{
    		mensagem('Erro na requisição','Algum erro aconteceu! Tente mais tarde');
    	} 	        
   });
}));

//voltar do passo 2 para o 1
$("#voltar-btn_um").click(function(){
	$("#box_nome").fadeOut('slow',function(){
		$("#box_console").fadeIn('fast'); //mostrar quadro do cadastro do nome do jogo da imagem
	});
});
//voltar do passo 2 para o 1
$("#voltar-btn_dois").click(function(){
	$("#box_imagem").fadeOut('slow',function(){
		$("#box_nome").fadeIn('fast'); //mostrar quadro do cadastro de imagem
		$("#output").html("");
		$("#arquivo").val("");
	});
});


/*DEPOIS DE TODOS OS PASSOS, CADASTRAR A IMAGEM*/
$('#imagem-btn').click(function(){
	var imagem = $("#nome-imagem").val();
	var idConso = $("#id-console").val();
	var nome = $("#nome-jogo").val();

	if(imagem == '' || idConso == '' || nome == ''){
		mensagem('Erro ao cadastrar!','Todas as informações devem ser preenchidas');
	}else{
		$.ajax({
        	url: "cadastra.php",
			type: "POST",
			data      : 'idConso='+ $("#id-console").val() +'&nome='+ $('#nome-jogo').val() +'&imagem='+ $('#nome-imagem').val(),
       		dataType  : 'html',
			success: function(data)
		    {			    	
		    	if(data==''){				    		
		    		var href = 'imagens.php';
					$("#conteudo_principal").load(href + "#conteudo_principal");
		    	}else{
		    		mensagem('Erro!',data);
		    	}
		    },
		  	error: function() 
	    	{
	    		mensagem('Erro na requisição','Algum erro aconteceu! Tente mais tarde');
	    	} 	        
  		});
	}
});

/*SE CANCELAR O PROCESSO DE CADASTRAR IMAGEM, VOLTAR PARA A PÁGINA DAS IMG'S*/
$(".btn_negar").click(function(){			
	var href = 'imagens.php';
	$("#conteudo_principal").load(href + "#conteudo_principal");
});

});