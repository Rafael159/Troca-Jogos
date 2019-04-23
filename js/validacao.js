$(document).ready(function (){

function clean_field(){
	$('#rua').val('');
	$('#bairro').val('');
	$('#cidade').val('');
}
function address_cep(valor){
	//nova variável 'cep' somente com dígitos
	var cep = valor.replace(/\D/g, '');

	if(cep != ""){
		//validar CEP
		var validacep = /^[0-9]{8}$/;

		//valida formato do CEP
		if(validacep.test(cep)){
			//Preenche campos com "..." enquanto consulta webservices
			$('#rua').val('...');
			$('#bairro').val('...');
			$('#cidade').val('...');

			//Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
            	
            	if(!("erro" in dados)){
            		//preeencher campos
            		$('#erro_cep').html('');
            		$("#rua").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#cidade").val(dados.localidade);
                    $("#numero").focus();

                    $('#estado').val(dados.uf);/*mudar o estado de acordo com o CEP*/
            	}//end if
            	else{
            		clean_field();
            		$('#erro_cep').html("CEP não encontrado");
            	}
            });
		}
	}else{
		//cep inválido
		clean_field();
		$('#erro_cep').html("Formato do CEP inválido");
	}	
}

/*CHAMAR FUNÇÕES*/
load_states($('#estado'));//função que carrega os estados @param combo que recebe
load_console($('#console'));//função que carrega os consoles @param combo que recebe

$('#cep').blur(function(){
	var atual_cep = $(this).val();
	if(atual_cep != ""){
		address_cep(atual_cep);
	}
});

//Validar info de cadastro antes de enviar
	$("#form-cadastro").submit(function(e){
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
			nome:{
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
			senha:{
				required: true,
				minlength: 6
			},
			conf_senha:{
				required: true,
				equalTo: '#senha'
			},
			console:{
				required: true
			},
			termos:{
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
			senha:{
				required: 'A senha é obrigatória',
				minlength: 'Senha de conter pelo menos 6 caracteres'
			},
			conf_senha:{
				required: 'Por favor, confirme a senha',
				equalTo: 'As senhas não coincidem'
			},
			console:{
				required: 'Selecione um console'
			},
			termos:{
				required: 'Leia e Aceite os termos'
			}
		},
		submitHandler: function(){
			var form = $("#form-cadastro");
			$("#btCadastrar").prop("disabled", true);
			$.ajax({
                type: 'post',
                url: 'cadastrar.php',
                data: form.serialize(),
                success:function(result){
					console.table(result);               	
                	result = $.parseJSON(result);
					
                	if(result.status=='0'){
						$("#btCadastrar").prop("disabled", true);
                    	$('#msg_error').show().text(result.mensagem);
                    }else{                    	
                    	window.location.href = 'register-confirmation.php';
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                	$('#msg_error').show().text("Infelizmente ocorreu um erro! Tente novamente");
                }
            },'jSON');
		}
	});

$('#btCancelar').click(function(){
	event.preventDefault();
	window.location.href = 'index.php';
});

});//FIM DO DOCUMENTO