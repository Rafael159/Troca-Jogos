$(document).ready(function(){
	
	$('#selecao').change(function(){
		op = $(this).val();//opção para exibição
		
		cod = $('#cod').val();//id console
		$.ajax({
			url:"require/buscaJogo.php",
			type:"POST",
			dataType:"html",
			data:{op:op, cod:cod},
			success:function(dados){				
				$('#boxGame').html(dados);
			}
		});
	});
	
});