$(document).ready(function (){	
	$('#telefone').mask('(99) 9999-9999');
	$('#cep').mask('99999-999');

	$('#celular').mask('(99) 99999-9999');
	$('#celular').blur(function(event){
		if($(this).val().length == 15){ //celular 9 dígito + 2 digs DDD e 4 da máscara
			$('#celular').mask('(00) 0000-00009');
		}else{
			$('#celular').mask('(00) 0000-00009');
		}
	});

	$('#txtValor').mask('00,00');
});