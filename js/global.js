$(document).ready(function (){
	/*** FUNÇÃO QUE COLOCARÁ COR AO FUNDO DA IMAGEM, DE ACORDO COM O CONSOLE  ***/
function colorir(){	
	/*mudar cor do fundo das imagens dos jogos*/
	$('.contorno figure').each(function(i){  /*percorre todas as divs com o nome .contorno figure*/ 

	var vg = $(this).attr("nome");/*recupera o nome do console/video game*/
	/*cor referente ao console*/
	if(vg == 'XBOX 360'){cor='#2CAC35'}
	else if(vg == 'XBOX ONE'){cor = '#0E7B0E'}
	else if(vg == 'PS3'){cor = '#D1CCC9'}
	else if(vg == 'PS4'){cor = '#0B86F9'}
	else if(vg == 'PS VITA'){cor = '#024ABE'}
	else if(vg == 'WII'){cor = '#ffffff'}
	else if(vg == 'WII U'){cor = '#0395C8'}
	else if(vg == 'PC'){cor = '#2A2A2A'}
	else{cor = '#efefef'};/*3DS*/
        // Aplica a cor de fundo 
        $(this).css({"background":cor});          	
    }); 			
}//FINAL FUNÇÃO COLORIR()

function pesquisarjogo(){
	$.ajax({		
		url: 'buscar.php',
		type: 'POST',
		dataType: 'html',
		data: $('.filterConsole:checked, .filterGenre:checked, #box_pesquisa').serialize(),

		success:function(vlue){
			$("#box-resultados").html(vlue);
			setTimeout(function(){
				colorir();
			});
		}
	});
}

$('.categoria .filterConsole').on('change', function(e){
	e.preventDefault();
		
	if($(this).is(':checked')){
		$(this).parent().parent().parent().addClass('filtro-actived');
	}else{
		$(this).parent().parent().parent().removeClass('filtro-actived');
	}
	pesquisarjogo();//pesquisar jogo
});

$('.genero .filterGenre').on('change', function(e){
	e.preventDefault();

	pesquisa = $("#box_pesquisa #id_pesquisa").val();
	
	if($(this).is(':checked')){
		$(this).parent().parent().parent().addClass('filtro-actived');
	}else{
		$(this).parent().parent().parent().removeClass('filtro-actived');
	}
	pesquisarjogo();//pesquisar jogo
});

//----=   Essa função fará a busca do valor ao clicar no filtro pelo NOME DO JOGO e mandar para a pesquisa() =-----//
$("#box_pesquisa #id_pesquisa").keyup(function(e){
	e.preventDefault();
	
	search = $(this).val();//valor vindo do campo
	if(search.length >= 4){
		pesquisarjogo();//pesquisar jogo
	}
});//FINAL DO CÓDIGO DE FILTRO PELO NOME

//insere valor clicado no campo de pesquisa
window.set_item = function(item){
	//troca valor do input
	$('.pesquisa').val(item);
	
	//esconder pesquisa	
	$('#lista_jogos').fadeOut();	
}
function slice_string(str){
	return str.slice(0,25);
}

function list_games(key, jogo_lista){	
	$.ajax({
        url: 'ajax_refresh.php',
        type: 'POST',
        data: {keyword:key},
        dataType: 'json',
        success: function(data){
        	
     		if(data.length > 0){
     			var linha = '';
     			$.each(data, function(chave, dados){
					/*criar */
					console.log(chave);
					if(chave <= 4){
						linha += "<li class='autoJogo' onclick='set_item(\""+dados.jogo+' - '+ dados.console + "\")'><img src='game/imagens/"+dados.consolesemEspaco+"/"+dados.imagem+"'/><h3 class='title-game'>"+ slice_string(dados.jogo) + ' - ' + dados.console + "</h3></li>";
					}else return false;
				});
				
				if(data.length > 4){
					linha += "<li class='autoJogo'><a href='pesquisa.php?pesquisa="+key+"'>Ver mais jogos para a pesquisa '"+key+"'</a></li>";
				}

          		$('#'+jogo_lista).show().html(linha);//colocar dados na div
     		}else{
     			$('#'+jogo_lista).html('').fadeOut();
     		}
     	}
    });
}
window.autoCompletar = function(input){	
	lista_de_jogos = $(input).next().attr('id');
	
	///***  Função de autocomplete  ****///
	tam_min = 3; //número mínino de caracteres necessários para o autocomplete rodar
    keyword = $(input).val();
    
    if (keyword.length >= tam_min){
    	list_games(keyword, lista_de_jogos);
    } else {
       $(input).next().hide();/*se tiver menos de 3 caracteres*/
    }
}

/*quando clicar fora da pesquisa*/
$(":not(#lista_jogos)").bind('click',function(){
	$('#lista_jogos').hide();
});

/*quando clicar fora da pesquisa*/
$(":not(#opcao_jogo)").bind('click',function(){
	$('#opcao_jogo').hide();	
});

/*quando o input receber o foco*/
$('.pesquisa').focus(function(){
	input = $(this);
    autoCompletar(input);
	/*document.querySelector('body').addEventListener('keydown', function(event){
		var tecla = event.keyCode;
		if(tecla == 40){
			$('#lista_jogos li').hover();
			return false;
		}else if(tecla == 38){
			alert('38');
			return false;
		}
	});*/
});

});