$(document).ready(function(){
    
    $('button[name=btn-recover]').on('click', function(ev){
        ev.preventDefault();
        
        email = $('input[name=email_recover]').val();
      
        if(email.length > 0){
            
            $.ajax({
                method:'POST',
                url: 'verifica.php',
                data: {email: email, tipo: 'recuperar'},
                success: function(dados){
                    dados = JSON.parse(dados);
                            
                    if(dados.status == '0'){
                        //erro
                        $('#return_msg').addClass('alert-danger').text(dados.mensagem).fadeIn();
                    }else{
                        mensagem = "Um e-mail com um link para redefinição da senha foi enviado para <b style='font-size:1.2em'>" + dados.mensagem + "</b>";
                        mensagem += "<br/> Verifique o seu e-mail para redefinir a sua senha";

                        $('#email_recover, #btn-voltar, #btn-recover, .lbl_info').hide();
                        $('#btn-back').fadeIn();
                        $('#return_msg').removeClass('alert-danger').addClass('alert-success').html(mensagem).fadeIn();
                    }
                }
    
            }, 'jSON');
        }else{
            $('#return_msg').removeClass('alert-success').addClass('alert-danger').html('Informe um email').fadeIn();
        }
    });

});