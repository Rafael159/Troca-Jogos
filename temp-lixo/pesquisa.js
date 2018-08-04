//autocomplete: Será executada todas as vezes que o texto for alterado no campo pesquisa
function auto() {
    var tam_min = 3; //número mínino de caracteres necessários para o autocomplete rodar
    var keyword = $('#id_pesquisa').val();
    if (keyword.length >= tam_min){
      $.ajax({
        url: 'ajax_refresh.php',
        type: 'POST',
        data: {keyword:keyword},
        success: function(data){
          $('#lista_jogos').show();
          $('#lista_jogos').html(data);
         }
      });
    } else {
       $('#lista_jogos').hide();
    }
}

//função será executada quando for escolhido um item
function set_item(item){
	//troca valor do input
	$('#id_pesquisa').val(item);
	//opções desaparecerá
	$('#lista_jogos').hide();
}