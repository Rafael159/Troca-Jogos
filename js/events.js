$(document).ready(function (){
	
	function logar_user(form, type){
		
		idfrm = form.attr('id');
		switch(type){
			case 1:
				link = 'login/verifica.php';
				urladm = 'admin/';
				urluser = 'users/';
			break;
			case 2:
				link = 'verifica.php';
				urladm = '../admin/';
				urluser = '../users/';
			break;
		}
		$.ajax({
			method:'POST',
			url: link,
			dataType:'json',
			data: form.serialize(),
			success: function(dados){
								
				if(dados.status == '0'){
					$('#result').text(dados.mensagem).fadeIn();//error
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
	$("#btn-logar").bind('click',function (ev) {
		ev.preventDefault();
		
		frm = $('#form-acesso');//formulário de login
		logar_user(frm, 1);
	});

	$("#btn_enviar").bind('click',function (ev) {
		ev.preventDefault();
		frm = $('#form-logar');//formulário de login		
		logar_user(frm, 2);		
	});

/*chama formulário de login*/
	window.overlayer = function(modal){
		var body = $("html, body");
		body.stop().animate({scrollTop:0}, '500', 'swing');
		$("#overlay").fadeIn(function(){
			$('body').css("overflow","hidden");//barra de rolagem some
			$(modal).show().animate({ //aparece o formulário
				top:'200px'
			});
		});
	}

	$(".access-login").on('click', function(){
		modal = $("#box-login");
		overlayer(modal);
	});

	/*chama formulário de cadastro*/
	$(".access-register").on('click', function(){
		modal = $("#box-cadastro");
		overlayer(modal);
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

	/*Efeito nos detalhes do jogo*/
	$(".quadro-galeria:first-child").fadeIn();
	$(".galeria .box-galeria-jogos li:first").addClass("actived");
	
	$(".galeria .box-galeria-jogos li").click(function(){			
		$(".galeria .box-galeria-jogos li").each(function(i){
			$( "li:not(actived)").removeClass("actived");
		});
		$(this).addClass("actived");
		/*recebe o link que será mostrado*/			
	});

	/*mostra as informações dos jogos ao passar o mouse sobre o jogo - vitrine de cada console*/
	$(".vitrine").hover(function(){ 
		//alert('ok');
	});       

	function colorir(){	
		/*mudar cor do fundo das imagens dos jogos*/
		$('.contorno figure').each(function(i){  /*percorre todas as divs com o nome .contorno figure*/ 		
		
		var console = $(this).attr("nome");/*recupera o nome do console*/
		/*cor referente ao console*/
		if(console == 'XBOX 360'){cor='#2CAC35'}
		else if(console == 'XBOX ONE'){cor = '#0E7B0E'}
		else if(console == 'PS3'){cor = '#D1CCC9'}
		else if(console == 'PS4'){cor = '#0B86F9'}
		else if(console == 'PS VITA'){cor = '#024ABE'}
		else if(console == 'WII'){cor = '#ffffff'}
		else if(console == 'WII U'){cor = '#0395C8'}
		else if(console == 'PC'){cor = '#ffffff'}
		else{cor = '#efefef'};/*3DS*/
            // Aplica a cor de fundo 
            $(this).css({"background":cor});          	
        }); 			
	}
	colorir();/*chamar a função colorir para definir as cores das primeiras imagens carregadas*/
	/*
	 * FILTRAR JOGOS PELO CONSOLE - LIMIT 5
	*/
	function gameByConsole(cod){
		$.post('require/listarCategoria.php',{id:cod},function(retorno){
			$("#galeria").html(retorno);
		});
	}
	gameByConsole(1);
	$(".galeria .box-galeria-jogos li.link").bind('click', function(){
		var id = $(this).val();
		
	  	gameByConsole(id);		
	});

	function setIcons(){
		$(".filterGenre").each(function(){
			item = $(this);
			genero = $(this).attr('id');
			var path = item.parent().prev();
			switch(genero){
				case 'acao':
				break;
				case 'corrida':
					path.addClass('fas fa-car fa-2x');
				break;
				case 'puzzle':
					path.addClass('fas fa-puzzle-piece fa-2x');
				break;
				case 'esportes':
					path.addClass('far fa-futbol fa-2x');				
				break;
				case 'musical':
					path.addClass('fas fa-music fa-2x');				
				break;
				case 'shooter':
					path.addClass('fas fa-bullseye fa-2x')
				break;
				case 'aventura':
					path.addClass('fas fa-skiing fa-2x');
				break;
				case 'terror':
					path.addClass('fas fa-exclamation-triangle fa-2x');
				break;
				case 'estrategia':
					path.addClass('fas fa-chess-knight fa-2x');
				break;
			}
		});
	}
	setIcons();
});