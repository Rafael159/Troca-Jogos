$(document).ready(function(){

    if(typeof(form_values) != 'undefined'){
        
        $('input[name=nome]').val(form_values.nome);
        $('input[name=email]').val(form_values.email);
        $('input[name=celular]').val(form_values.celular);
        $('input[name=telefone]').val(form_values.telefone);
        $('input[name=cep]').val(form_values.cep);
        $('input[name=rua]').val(form_values.rua);
        $('input[name=numero]').val(form_values.numero);
        $('input[name=cidade]').val(form_values.cidade);
        $('input[name=bairro]').val(form_values.bairro);        
        if(form_values.estado) setEstados('select[name=estado]');
        if(form_values.console) setConsoles('select[name=console]');
        $('input[name=complemento]').val(form_values.complemento);
    }

    function setConsoles(select){
        $.post("carrega-consoles.php", function(data){
            $(select).html(data);
            if(form_values.console!='undefined') $('select[name=console]').val(form_values.console); 
        });

    }
    /* Carregar combo dos ESTADOS
	** @param selectBox
	** @param function - recebe o combobox que será preenchido
	*/
	function setEstados(select){
		$.getJSON('../util/estados.json', function(dados){
			var comboBox = $(select);//combo que receberá os estados 
			
			$.each(dados, function(uf, state){//uf = Sigla  <---> state = Nome do estado
                $('<option>').val(dados[uf].Sigla).text(dados[uf].Nome).appendTo(comboBox);//popular comboxBox
            });
            if(form_values.estado!='undefined') $('select[name=estado]').val(form_values.estado); 
		});
	}

    
});