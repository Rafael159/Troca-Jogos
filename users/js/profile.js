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
        //if(form_values.estado) setEstados('select[name=estado]');        
        if(form_values.console) setConsoles('select[name=console]');
        $('input[name=complemento]').val(form_values.complemento);
        setEstados('select[name=estado]');//setar estados
    }

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

    //$(".msgcrud").fadeOut();
    //setTimeout(function(){
        //$('.msgcrud').slideUp();
    //}, 3000);


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
			//uf = Sigla  <---> state = Nome do estado
			$.each(dados, function(uf, state){
                $('<option>').val(dados[uf].Sigla).text(dados[uf].Nome).appendTo(comboBox);//popular comboxBox
            });
            if(form_values.estado!='undefined') $('select[name=estado]').val(form_values.estado); 
		});
	}
    
    //Validar info de cadastro antes de enviar
	$("#form-update").submit(function(e){
        e.preventDefault();	 	
    }).validate({
       onKeyup : true,
           eachValidField : function() {
               $(this).closest('div').removeClass('error').addClass('success');
           },
           eachInvalidField : function() {
               $(this).closest('div').removeClass('success').addClass('error');
           },				
       rules: {
           /*nome:{
               required: true,
               minlength:5
           },
           email:{
               required: true,
               email: true
           },
           celular:{
               required: true,
               minlength:14			
           },
           console:{
               required: true
           }

       },
       messages:{
           nome:{
               required:'Por favor, informe seu nome',
               minlength: 'O nome deve ser pelo menos 5 caracteres'
           },
           email:{
               required: 'Por favor, informe um email',
               email: 'Informe um email válido'
           },
           celular:{
               required: 'Informe um número de celular',
               minlength: 'Celular inválido'				
           },
           console:{
               required: 'Selecione um console'
           }*/
       },
       submitHandler: function(){
           var form = $("#form-update");
           
           $.ajax({
               type: 'post',
               url: 'update-register.php',
               data: form.serialize(),               
               success:function(retorno){
                   var obj = JSON.parse(retorno);
                
                   if(obj.status=='0'){
                       $('.fail').html(obj.mensagem).fadeIn();                        
                       setTimeout(function(){
                         $('.fail').fadeOut('slow').html('');
                       }, 3000);

                   }else{
                       $('.msgcrud').fadeIn('slow').html(obj.mensagem);
                       setTimeout(function(){
                        $('.msgcrud').html('').fadeOut('fast');
                      }, 3000);

                   }
               },
               error: function(jqXHR, textStatus, errorThrown){
                   $('.fail').show().html("Infelizmente ocorreu um erro ao atualizar o cadastro! Tente novamente");
               }
           }, 'jSON');
       }
   });
});