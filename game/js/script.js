$(document).ready(function(){
	/*ENVIAR EMAIL E SENHA PARA LOGAR AO SITE*/
	$("#btn-login").bind('click', function () {
		form = $('#form-logar');
		logar_user(form, 1, '../login/verifica.php', '../admin/','../users/');
	});
	
	function callModal(modal){
		var body = $("html, body");
		body.stop().animate({scrollTop:0}, '500', 'swing');
		$("#overlay").fadeIn(function(){
			// $('body').css("overflow","hidden");//barra de rolagem some
			$(modal).show().animate({ //aparece o formulário
				top:'200px'
			});
		});
	}

	/*chama formulário de login*/
	$("#user-entrar, #btnTrocaLogar").bind('click',function (e){	
		e.preventDefault();		
		box = $("#box-login");
		callModal(box);
	});

	/*chama formulário de cadastro*/
	$("#user-cadastrar").bind('click',function (ev){
		ev.preventDefault();
		box = $("#box-cadastro");
		callModal(box);
	});

	/*cancela login e/ou cadastro*/
	$(".btn_cancela_acesso").click(function(){
		$(this).parent().animate({
			top:'-50%'
		}).hide('slow');
		$("#overlay").fadeOut(function(){
			$('body').css("overflow","visible");
		});			
	});		
});