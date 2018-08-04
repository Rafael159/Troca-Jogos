$(document).ready(function (){

	window.logar_user = function(form, type, link, urladm, urluser){
		idfrm = form.attr('id');
		
		$.ajax({
			method:'POST',
			url: link,
			dataType:'json',
			data: form.serialize(),
			success: function(dados){
				//console.log(dados);
				if(dados.status == '0'){
					$("#"+idfrm+" #result").html(dados.mensagem).slideDown();//error
				}else{
					if(dados.nivel == '1'){
						window.location.href=(urladm+"admin.php");//Dashboard admin
					}else{
						window.location.href=(urluser+"dashboard.php");//Dashboard usuário comum
					}
				}
			}
		});
	}

	/*ENVIAR EMAIL E SENHA PARA LOGAR AO SITE*/
	$("#btn-logar").bind('click',function () {
		frm = $('#form-acesso');//formulário de login
		logar_user(frm, 1, 'login/verifica.php', 'admin/','users/');
	});

	$("#btn_enviar").bind('click',function () {
		frm = $('#form-logar');//formulário de login		
		logar_user(frm, 2, 'verifica.php', '../admin/', '../users/');		
	});

	/* Popular combo com todos os CONSOLES
	** @param select - nome do select para exibição
	** @param function - recebe o combobox que será preenchido
	*/
	window.load_console = function(select){
		$.ajax({
			method:'POST',
			url: 'controllers/carregaConsole.php',
			dateType:'json',
			contentType: 'application/json',
			success: function(dados){
				
				if(dados != null){
					var consoles = $.parseJSON(dados);//transforma string em objeto
					var selectBox = select;
					
		            $.each(consoles, function(key, value){
		               $('<option>').val(value.id_console).text(value.nome_console).appendTo(selectBox);//populando select
		            });
				}            
			}
		});
	}
	
	/* Carregar combo dos ESTADOS
	** @param selectBox
	** @param function - recebe o combobox que será preenchido
	*/
	window.load_states = function(selectBox){
		$.getJSON('util/estados.json', function(dados){
			var comboBox = selectBox;//combo que receberá os estados 
			
			$.each(dados, function(uf, state){//uf = Sigla  <---> state = Nome do estado
				$('<option>').val(dados[uf].Sigla).text(dados[uf].Nome).appendTo(comboBox);//popular comboxBox
			});
		});
	}	

});



