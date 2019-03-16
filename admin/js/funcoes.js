$(document).ready(function(e){
	/*
	 * PÁGINA COM AS AÇÕES E ANIMAÇÕES DA PÁGINA ADMIN.PHP 
	 */
	 $("#esquerda .mn_admin .mn_opcao").on('click', function(e){ // quando clicar em uma opção
		e.preventDefault();
		
		if($(this).hasClass("actived")){
			$(this).removeClass("actived");
		}else{			
			$("#esquerda .mn_admin .mn_opcao").each(function(i){
				$("li:not(actived)").removeClass("actived");
			});
			
			var href = $(this).find('a').attr('href');//recupera href clicado
			//alert(href);	  			  		
			//verificar se já está ativo
			$(this).addClass("actived");
			$("#conteudo_principal").load(href + "#conteudo_principal");		
		}
	});


	$("#confirmar-btn").on('click', function(){
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

	// $("#btn-config").on('click', function(){
	// 	$("#box-config").fadeIn();//MOSTRAR AS OPÇÕES PARA CADASTRAR IMG'S					
	// });

	/*CHAMA A TELA DE CADASTRO DE IMAGENS*/
	$("#btn-add-img").on('click', function(){
		var href = 'cadastro_imagem.php';
		$("#conteudo_principal").load(href + "#conteudo_principal");
	});

	
	function acaoimagem(){
		/*DELETAR IMAGEM*/
		$(".icon-deletar").on('click',function(){
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
		$(".icon-editar").on('click', function(){
			var jogo = $(this).parent().parent().parent().find(".nm_jogo").val(); //recupera nome do jogo
			var id = $(this).parent().parent().attr('id'); //recupera o id da imagem

			$.post('atualiza_img.php',{ //envia para a página de exclusão
				id:id,jogo:jogo,
			}, function(retorno){
				if(retorno.status == 'erro'){ //se houver erro, mostre
					mensagem('Erro ao atualizar imagem!','Ocorreu um erro.Tente mais tarde');
				}else{
					mensagem('Sucesso', 'Imagem atualizada com sucesso');											
				}
			}, 'jSON');
		});
	}
	acaoimagem();//CONFIGURA O EFEITO NAS IMAGENS CARREGADAS
	
	$(".alert-btn").on('click', function(){						
			var acao = $(this).attr("name"); //recupera a ação desejada
			switch (acao){
				case 'confirma': //se confirmar
					var id =  $('#recuperaId').val(); //recupera o id da imagem
					$.post('delete.php',{ //envia para a página de exclusão
						id:id,
					}, function(retorno){						
						if(retorno.status == 'erro'){ //se houver erro, mostre
							mensagem('Erro ao excluir imagem!','Algum erro ocorreu, tente mais');
						}else{	//senão, atualiza a página
							var href = 'imagens.php'; 
							$("#conteudo_principal").load(href + "#conteudo_principal");
							$("html,body").css({"overflow-y":"visible"});
						}								
					}, 'jSON');
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
	$(".mn-console ul li.each-console").on('click', function(){
		if($(this).hasClass("actived")){ //Não fazer nada
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
	$(".galeria .box-galeria-jogos li").on('click', function(){

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

$("#confirmar-btn").on('click', function(){
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
$("#console-btn").on('click', function(){	
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
$("#nome-jogo-btn").on('click', function(){
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
				mensagem('Erro na requisição', data.erro);
			}
	    },	    
	  	error: function() 
    	{
    		mensagem('Erro na requisição','Algum erro aconteceu! Tente mais tarde');
    	} 	        
   });
}));

//voltar do passo 2 para o 1
$("#voltar-btn_um").on('click', function(){
	$("#box_nome").fadeOut('slow',function(){
		$("#box_console").fadeIn('fast'); //mostrar quadro do cadastro do nome do jogo da imagem
	});
});
//voltar do passo 2 para o 1
$("#voltar-btn_dois").on('click', function(){
	$("#box_imagem").fadeOut('slow',function(){
		$("#box_nome").fadeIn('fast'); //mostrar quadro do cadastro de imagem
		$("#output").html("");
		$("#arquivo").val("");
	});
});


/*DEPOIS DE TODOS OS PASSOS, CADASTRAR A IMAGEM*/
$('#imagem-btn').on('click', function(){
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
$(".btn_negar").on('click', function(){			
	var href = 'imagens.php';
	$("#conteudo_principal").load(href + "#conteudo_principal");
});

/*Função: Tirar espaços entre a letras
	 *@param str - string com espaço
	 *@return res - retorna string sem espaço
	*/
	function replacestr(str) {
		res = str.replace(/ /g, "");
		return res;
	}
	/*Função: Verificar o tipo de troca
	 *@param vlr - int contendo o tipo da troca
	 *@return type - retornar uma string com o tipo da troca
	*/
	function typeExchange(vlr){
		switch(vlr){
			case '0':
				type = "Meu jogo vale mais";
			break;
			case '1':
				type = "Equilibrado";
			break;
			default:
				type = "Meu jogo vale menos";
			break;
		}
		return type;
	}

viewTroca = function(idTroca){
	
	$.ajax({
		url : 'trocas/view-troca.php',
		type : 'post',
		data : 'idTroca='+idTroca,
		dataType : 'json'
	}).done(function(data){
		if(data.status == '0'){
			$('#box_error').modal();
			$('#box-msg-error').html(data.mensagem);
		}else{
			/*MONTAR BOX DE RETORNO*/
			console = replacestr(data.dados_troca[0].nome_console);
			imagem_oferta = data.dados_troca[0].imagem;
			valor = data.dados_troca[0].valor;
			jogo_oferta = data.dados_troca[0].n_jogo;/*nome do jogo*/
			mensagem = data.dados_troca[0].mensagem;
			type = typeExchange(data.dados_troca[0].tipo);
			statustroca = data.dados_troca[0].estado_atual;
			
			//dados do segundo jogo
			seg_console = replacestr(data.dados_jogo[0].nome_console);
			seg_img = data.dados_jogo[0].imagem;
			seg_jogo = data.dados_jogo[0].n_jogo;

			//dados do segundo usuário
			user_nome = data.dados_user.nomeUser;
			user_celular = data.dados_user.celular;
			user_telefone = data.dados_user.telefone;

			//primeiro jogo
			box = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">';
			box +=	'<div class="box-games" style="border: 2px solid #000">';
			box +=      '<span class="game-title">Jogo Principal</span>';
			box +=	    '<img src="../game/imagens/'+console+'/'+imagem_oferta+'" alt="'+jogo_oferta+'" class="img-responsive img-games"/>';
			box +=	'<label class="game-name">'+jogo_oferta+' <br> '+console+'</label></div></div>';     	
			//segundo jogo
			box += '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">';
			box +=    	'<div class="box-games" style="border: 2px solid #069">';
			box +=    		'<span class="game-title">Jogo Pretendido</span>';
			box +=    		'<img src="../game/imagens/'+seg_console+'/'+seg_img+'" alt="'+seg_jogo+'" class="img-responsive img-games"/>';
			box += '<label class="game-name">'+seg_jogo+' <br> '+seg_console+'</label></div></div>';

			box += '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">';
			box +=      '<div class="personal-info">';
			box +=			'<h4>Dados da troca</h4>';
			box +=          '<label class="info-troca">Tipo de troca:</label> <span class="real-info">'+type+'</span><br/>';
			box +=    		'<label class="info-troca">Valor de retorno:</label><span class="real-info"> R$'+valor+'</span><br/>';
			box +=    		'<label class="info-troca">Status atual:</label> <span class="real-info">'+statustroca+'</span><br/></div></div>';

			box +='<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">';
			box +='<div class="personal-info">';
			box +='<h4>Dados do destinatário</h4>';
			box +='<label class="info-troca">Nome: </label><span class="real-info"> '+user_nome+'</span><br/>';
			box +='<label class="info-troca">Celular: </label> <span class="real-info">'+user_celular+'</span><br/>';
			box +='<label class="info-troca">Telefone: </label><span class="real-info">'+user_telefone+'</span><br/></div></div>';

			box +='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			box +='<div class="personal-info"><div id="mensagem-troca"><span><strong>MENSAGEM: </strong>'+mensagem+'</span></div></div></div>';

			$('#view_troca').html(box);
			$('#view-modal').modal();
		}
	});		
}
});