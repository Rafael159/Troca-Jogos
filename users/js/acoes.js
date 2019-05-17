$(document).ready(function(){

/* Carrega os consoles
   @param - combo box que recebe os dados	
*/
load_console_user($('#console_add_game')); 

/* 
 * Função Selecionar a imagem do jogo e add no box da imagem
 * @param int op - 1 / meu jogo <--->  2 / jogo pretendido
 * @param obj div - essa div recebe o jogo escolhido
 * @param obj div2 - recebe as opções de jogos  
*/
function dragdrop(op,div, div2){
/*ESCOLHER IMAGEM*/
	$(div2+" .each-img").click(function(){
		var idImg = $(this).attr('id');
		$('#img_id').val(idImg);

		if($(div).is(":empty")){
			
			$(div).append($(this));
			if(op == 1){
				idImg = $("#boxmeujogo .each-img").attr('id');//id da imagem
				
				$('#console').attr("disabled","disabled");
				$('#delete_primeira_img #pop_botao_fecha').fadeIn();
			}else{
				$('.galeria, #minha-escolha').fadeOut('fast',function(){
					$("#delete_segunda_img #pop_botao_fecha").fadeIn();
				});
			}		
		}else{
			if($(div).find('.each-img')){
				$(div +" .each-img").appendTo($(div2));
				$(div).html("");
				$(div).append($(this));
			}else{
				$(div).append($(this));
			}							
		}	
	});
}
function replacestr(str) {
	res = str.replace(/ /g, "");
	return res;
}
/*
 * Função - Buscar a imagem do jogo
 * @param string jogo - nome do jogo
 * @param int id - código do console do jogo 
*/
function buscarJogo(jogo, id){	
	$.ajax({
    	url: "filtro.php",
		type: "POST",
		data      : 'id='+ id +'&jogo='+ jogo,
   		dataType  : 'json',
		success: function(retorno)
	    {	    	
	    	if(retorno.qnt == 0){
				$('#img_id').val('');//garantir que o campo esteja vazio
				$("#add_new_img").val("");//limpar file da imagem
				$('#imagem, #boxmeujogo').html('');//apagar conteúdo já existente no box de pesquisa
				$('.box_new_img').fadeIn();
				//$('#imagem').append(box);//inserir conteúdo
	    	}else{
	    		$("#add_new_img").val("");
	    		$('.box_new_img').fadeOut();
				$('#imagem, #boxmeujogo').html('');//apagar conteúdo já existente
				
	    		$.each(retorno, function(key, value){
	    			
	    			console = replacestr(value.nome_console); 

	    			//enviar imagens vindo do banco para o box
	    			box =   '<div class="each-img" id="'+value.id_img+'">';
					box +=	'<img src="../game/imagens/'+console+'/'+value.imagem+'" alt="'+value.nome+'" class="img-responsive image-game">'
					box +=  '</div>';
					
					$('#imagem').append(box);//inserir conteúdo
		    	});
		    }
		    dragdrop(1,"#boxmeujogo","#imagem");	    	  
	    },
	  	error: function() 
    	{
    		//vazio
    	}
	});
}

function buscar(jogo, id){
	if(jogo==''){
		$("#minha-escolha").css({border:'1px solid #ff0000'});
	}else{				
		$.ajax({
        	url: "filtro.php",
			type: "POST",
			data      : 'id='+ id +'&jogo='+ jogo,
       		dataType  : 'json',
			success: function(data)
		    {	
		    	if(data.qnt == 0){
		    		$('#jogo_escolha, #boxjogo_favorito').html('');//apagar conteúdo já existente
					$('.box_new_img2').fadeIn();
		    	}else{
		    		$('#boxjogo_favorito').show();
		    		$('#jogo_escolha, #boxjogo_favorito').html('');//apagar conteúdo já existente
					$('.box_new_img2').fadeOut();
		    		$.each(data, function(key, value){
		    			//enviar imagens vindo do banco para o box
		    			console = replacestr(value.nome_console);
		    			box =   '<div class="each-img" id="'+value.id_img+'">';
						box +=	'<img src="../game/imagens/'+console+'/'+value.imagem+'" alt="'+value.nome+'" class="img-responsive image-game">'
						box +=  '</div>';
						
						$('#jogo_escolha').append(box);//inserir conteúdo
			    	});
			    	dragdrop(2,"#boxjogo_favorito","#jogo_escolha");
			    }
		    },
		  	error: function()
	    	{
	    		//vazio
	    	} 	        
			});
	}					
}
/*
 * Função - Exibir mensagens
 * @param titulo - recebe o título da mensagem
   @param msg - recebe a mensagem	
*/
function mensagem(titulo, msg){
	/*levar a página para o topo e remover o scroll da página*/
		var body = $("html, body");
		body.stop().animate({scrollTop:0}, '500', 'swing', function() { 
		   body.css({"overflow-y":"hidden"});						 
		});
	$(".overlay").show();
	$("#msg header").html(titulo);
	$("#msg span").html(msg);
	$("#msg").fadeIn().animate({
		top:'15%'
	});			
}
/*
 * Função - Apagar dados do formulário
*/
function resetForm(){
	var form = $("#frm_jogos");
	form.each(function(){
		this.reset();
	});
}

// Carrega a imagem selecionada no elemento <img>
$("#add_new_img").on('change', function () { 	
    if (typeof (FileReader) != "undefined") {
 
        var image_holder = $("#boxmeujogo");
        image_holder.empty();
 
        var reader = new FileReader();
        reader.onload = function (e) {

            if(e != null){
        		$("<img />", {
	                "src": e.target.result,
	                "class": "thumb-image"
            	}).appendTo(image_holder);
        	}
        }
        image_holder.show();
        reader.readAsDataURL($(this)[0].files[0]);

    } else{
        alert("Este navegador não suporta Leitor de Imagens.");
    }
});

/* Carrega a imagem selecionada no elemento <img>*/
$("#add_new_img2").on('change', function () {
	
 	//$(this).val('');//apagar a imagem armazenada 
    if (typeof (FileReader) != "undefined") {
 
        var image_holder = $("#boxjogo_favorito");
        image_holder.empty();
 
        var reader = new FileReader();
        reader.onload = function (e) { 

        	if(e != null ){
        		$("<img />", {
	                "src": e.target.result,
	                "class": "thumb-image"
            	}).appendTo(image_holder);
        	}
        }
        image_holder.show();
        reader.readAsDataURL($(this)[0].files[0]);
        
    }else{
        alert("Este navegador não suporta FileReader.");
    }
});

//trocar as imagens de acordo com o console
$("#console_add_game").change(function(){
	$('#imagem').html('<img src="img/progresso.gif">');//imagem de loading

	jogo = $('#jogo').val();
	if(jogo.length > 4){
		var id= $(this).val();//id do console 

		if(id == 'Selecione'){

		}else if(jogo == ''){
			$('#jogo').focus();
		}else{		
			buscarJogo(jogo, id);//chama função de busca das imagens
		}
	}  
	 
});
$("#jogo").keyup(function(){
	jogo = $(this).val();//nome do jogo digitado

	if(jogo.length > 4){
		id = $("#console_add_game").val();//id do console
		
		if(id=='Selecione'){}else{		
			buscarJogo(jogo, id);//chama função que busca o jogo						
		}
	}
});		

//mostrar a opção para adicionar o jogo de troca
$('.radio-op').bind('click', function(){
	var op = $(this).attr('id');
	switch (op){
		case 'opnao':
			//reset todos os boxes
			$("#boxjogo_favorito, #jogo_escolha").html("");
			$("#container-second").fadeOut();
			$('.arrow').css({
				background:'#ff0000'
			});
			$('.arrow').animate({
				left:'26px'
			});
			$("#minha-escolha, .galeria").fadeOut('slow', function(){
				$(this).val('');
			});
		break;
		case 'opsim':
			$('.arrow').css({
				background:'#02cb66'
			});
			$('.arrow').animate({
				left:'48px'
			});							
			
			$(".galeria").fadeIn();
		break;
		default:
	}
});

/*CONSOLES*/
var id, jogo;
$(".galeria .box-galeria-jogos li").click(function(){

	$(".galeria .box-galeria-jogos li").each(function(i){ //destacar o console clicado
		$( "li:not(actived)").removeClass("actived");
	});
	$(this).addClass("actived");
	$(".galeria .box-galeria-jogos li").each(function(i){				
		if($(this).hasClass("actived")){	
			id = $(this).val();	//id do console								
		}				
	});

	$("#container-second").fadeIn();
	$("#minha-escolha").fadeIn();
	jogo = $("#minha-escolha").val();
	if(jogo.length > 4){
		buscar(jogo, id);	
	}				
			
});

$("#minha-escolha").keyup(function(){
	jogo = $(this).val();
	if(jogo.length > 4){
		$(".galeria .box-galeria-jogos li").each(function(i){				
			if($(this).hasClass("actived")){	
				id = $(this).val();	//id do console							
			}				
		});
		buscar(jogo, id);//chama função para pesquisar o jogo
	}
	
});	

$("#delete_primeira_img img").click(function(){
	$("#img_id").val('');
	$("#boxmeujogo .each-img").appendTo($("#imagem"));
	$("#boxmeujogo").html("");
	$("#add_new_img").val("");
	$('#console_add_game').attr("disabled",false);
});
$("#delete_segunda_img img").click(function(){
	$("#boxjogo_favorito .each-img").appendTo($("#jogo_escolha"));
	$("#boxjogo_favorito").html("");
	$('.galeria , #minha-escolha').fadeIn('slow');		
});

/*BOTÃO CONFIRMAR*/
$("#confirmar-btn").click(function(){
	$("#msg").animate({
		top:'-50%'
	}, function(){
		$("#msg").fadeOut();
		$(".overlay").fadeOut();
		$('html, body').css({"overflow-y":"visible"});
	});
});

$('#confirm-record').bind('click', function(){
	$('#modal_success').modal('hide');
	reload('jogos.php');
});

/*CADASTRAR JOGO*/
$("#btn-cadastra").bind('click', function(ev){
	ev.preventDefault();
	// Captura os dados do formulário
	var formulario = document.getElementById('frm_jogos');
	// Instância o FormData passando como parâmetro o formulário
	var formData = new FormData(formulario);
	// Envia O FormData através da requisição AJAX

	$("#btn-cadastra").prop("disabled", true);

	$.ajax({
	   url: "processaJogo.php",
	   type: "POST",
	   data: formData,
	   dataType: 'json',
	   processData: false,  
	   contentType: false,
	   success: function(retorno){
	   		//0 - algum erro		   	
   			if (retorno.status == '0'){
   				$('#msg_error').html(retorno.mensagem).fadeIn();
   				setTimeout(function(){
					$('#msg_error').fadeOut();//esconder div de erro dps de 3s
   				},3000);
   				$("#btn-cadastra").prop("disabled", false);
   			}else{
   				//tudo okay   			
   				qnt = $('#jogos .badge').text();
		   		qnt = parseInt(qnt) + 1;//add 1
   				$('#jogos .badge').text(qnt);/*atualizar quantidade de jogos temporariamente*/

   				$('#modal-add-game').modal('toggle');//esconder form
   				resetForm();//apagar valores do formulário
   				$('#feedback_message').fadeIn();//mostrar box da msg
				$('#feedback_message #message').html(retorno.mensagem);	//add mensagem
				$("#btn-cadastra").prop("disabled", false);
   			}	   			
   	   }
	});
});


/*CANCELAR CADASTRO DE JOGO*/
$("#btn-cancela").bind('click',function(e){
	e.preventDefault();
	resetForm();
	$('#modal-add-game').modal('hide');
});
/*
	AQUI COMEÇA OS EFEITOS E AÇÕES DA PÁGINAS JOGOS.PHP
*/
function acaoimagem(){
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

		$.post('atualiza_img.php',{ //envia para a página de atualização
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

	//ATUALIZA E DELETA JOGO
	$('.each-game').click(function(){
		idJ = $(this).attr('id');
		
		/*faz requisição e retorna o jogo pelo ID*/
		$.ajax({			
        	url: "consulta_jogo.php",/*arquivo que faz a requisição*/
			type: "POST",
			dataType:'html',
			data:'idJ='+ idJ,/*ID do jogo*/
			success : function(data){;
				/*levar a página para o topo e remover o scroll da página*/
				var body = $("html, body");
				body.stop().animate({scrollTop:0}, '500', 'swing');											
					$('#up_del_game').modal('show');
					$('#boxAtualiza').html('<img src="img/progresso.gif" alt="Loading...">');
					setTimeout(function(){
						$('#boxAtualiza').html(data);
					},2000);			
				},
			error: function(jqXHR, textStatus, errorThrown){
				$('#up_del_game').modal('show');
				$('#boxAtualiza').text("Desculpa :( Ocorreu um erro no carregamento do jogo! Tente novamente");
			}
		});
	});
});//final do SCRIPT