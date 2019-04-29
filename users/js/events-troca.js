$(document).ready(function(){

	/* Função: buscar as trocas por categoria
	*  @param type - situação da troca (todas/aceitas/recusadas/etc)
	*/
	function show_exchanges(type){
		
		$.ajax({
			url : 'consulta_troca.php',
			type: 'post',
			data: 'type='+type,			
			dataType: 'html'
		}).done(function(dados){	
			if(dados == ''){
				$('#list').html('<span class="error_msg">Nenhuma troca encontrada!</span>');
			}else{
				$('#list').html(dados);
			}
		});
	}
	show_exchanges('all');/*primeiro load da página*/
	/*mudar tipo de trocas*/
	$('.btn_exchange').bind('click', function(){		
		btn = $(this);//pegar botão clicado
		$('.btn_exchange').each(function(){
			if($(this).hasClass('btnActived')){
				$(this).removeClass('btnActived');
			}
		});
		btn.addClass('btnActived');
		type = $(this).attr('id');/*tipo da consulta*/
		
		show_exchanges(type);/*chama função que mostra as trocas*/
	});

	$("button[name=btnsendclose]").bind('click', function(evt){
		evt.preventDefault();
		
		mensagem = $("textarea[name=msgaceite]").val();
		idto = $("input[name=by_user]").val();
		if(mensagem && idto){
			$.post("../controllers/sendMessage.php", {mensagem: mensagem, idto: idto}, function(result){				
				if(result=="OK"){
					$('textarea[name=msgaceite]').val('');
					$("#modal-accepted").modal('toggle');
				}else{
					$('textarea[name=msgaceite]').val('');
					$("#modal-accepted").modal('toggle');
				}
			}, 'JSON');
		}else{
			$("#modal-accepted").modal('toggle');
		}
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
	/*FUNÇÃO MUDA STATUS DA TROCA
	 * @param idtroca = recebe o id da troca
	 * @param tipotroca = 1{aceita} 2{recusa}
	 */
	window.update = function(idtroca, tipotroca){

		if(tipotroca=='Cancelada' || tipotroca=='Finalizada'){
			idtroca = $('input[name=idtroca]').val();
		}
		
		$.ajax({
			url : 'update-troca.php',
			type: 'post',
			data: 'idtroca='+idtroca+'&type='+tipotroca,	
			dataType: 'html'
		}).done(function(dados){
						
			if(dados.status == '0'){
				$('#box_error').modal();
				$('#box-msg-error').html(dados.mensagem);
			}else{
				if(tipotroca=="Aceito"){
					$("#accepted").addClass("btnActived");
					show_exchanges('accepted');
					$("#modal-accepted").modal('toggle');
					$(".msgpara").html(dados.nomeUser);
					$("input[name=by_user]").val(dados.by_user);
				}else if(tipotroca=="Cancelada" || tipotroca=="Finalizada"){
					$("#all").addClass("btnActived");
					show_exchanges('all');
					$("#modal-finaliza").modal('toggle');
				}else{
					qnt = $('#trocas .badge').text();
			   		qnt = parseInt(qnt) - 1;//add 1
	   				$('#trocas .badge').text(qnt);/*atualizar quantidade de jogos temporariamente*/

					show_exchanges('refused');
				}
			}
		});
	}
	/*Função: gerar o box para confirmar deleção
    * @param cod - id da troca
	*/
	confirmDelete = function(cod){
		$.ajax({
			url : 'delete-troca.php',
			type: 'post',
			data: 'codigo='+cod,
			dataType: 'json'
		}).done(function(dados){			
			if(dados.status == '0'){
				$('#box_error').modal();
				$('#box-msg-error').html(dados.mensagem);
			}else{
				show_exchanges('all');
			}
		});
	}

	/*Função: recusar exclusão da troca
    * @param obj - recebe o botão clicado
	*/
	cancelDelete = function(obj){
		$(obj).parent().closest('.confirm-box').hide('slow', function(){
			$(obj).parent().closest('.confirm-box').prev().show('fast');
		});
	}	
	/*Função: gerar o box para confirmar deleção
    * @param obj - recebe o botão clicado
    * @param cod - id da troca
	*/
	deleteTroca = function(obj){		
		// $(obj).parent().next().hide();
		$(obj).parent().next().show('slow', function(){
			$(obj).parent().hide('fast');
		});
	}

	viewTroca = function(idTroca){		
		$.ajax({
			url : 'view-troca.php',
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

	finalizarTroca = function(id){
		$("input[name=idtroca]").val(id);
		$("#modal-finaliza").modal("toggle");
	}
});