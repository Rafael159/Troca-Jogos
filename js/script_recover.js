$(document).ready(function () {

    $('button[name=btn-recover]').on('click', function (ev) {
        ev.preventDefault();

        email = $('input[name=email_recover]').val();

        if (email.length > 0) {
            $("button[name=btn-recover]").prop("disabled", true);
            $("#progress").css("display", "block");
            $.ajax({
                method: 'POST',
                url: 'verifica.php',
                data: { email: email, tipo: 'recuperar' },
                dataType: 'json',
                success: function (dados) {
                    console.table(dados);
                    //dados = JSON.parse(dados);
                   
                    if (dados.status == '0') {
                        //erro
                        $("#progress").css("display", "none");
                        $("button[name=btn-recover]").prop("disabled", false);
                        $('#return_msg').addClass('alert-danger').text(dados.mensagem).fadeIn();
                    } else {
                        $("button[name=btn-recover]").prop("disabled", false);
                        $("#progress").css("display", "none");
                        mensagem = "Um link para redefinição da senha foi enviado para <br/><b style='font-size:1.2em'>" + dados.mensagem + "</b>";
                        mensagem += "<br/> Verifique o seu e-mail para redefinir a sua senha";
                        mensagem += "<br/> Você deve redefinir sua senha em até <b>24h</b>. Após esse prazo o link enviado expirará";

                        $('#email_recover, #btn-voltar, #btn-recover, .lbl_info').hide();
                        $('#btn-back').fadeIn();
                        $('#return_msg').removeClass('alert-danger').addClass('alert-success').html(mensagem).fadeIn();
                    }
                }

            }, 'jSON');
        } else {
            $('#return_msg').removeClass('alert-success').addClass('alert-danger').html('Informe o mesmo email cadastrado no site').fadeIn();
        }
    });

    $('#btn-recoverpass').on('click', function (e) {
        e.preventDefault();

        email = $('#email').val();
        senha = $('#new_pass').val();
        confirm_pass = $('#confirm_pass').val();

        if (senha.length > 0 && confirm_pass.length > 0) {            
            $("#btn-recover").prop("disabled", true);
                        
            $.ajax({
                method: 'POST',
                url: 'verifica.php',
                data: { email: email, senha: senha, confirm_pass: confirm_pass, tipo: 'recuperasenha' },
                success: function (dados) {
                    dados = JSON.parse(dados);
                    if (dados.status == '0') {
                        //erro
                        $('#return_msg').addClass('alert-danger').text(dados.mensagem).fadeIn();
                    } else {
                        $('#new_pass').val('');
                        $('#confirm_pass').val('');

                        $('#btn-recoverpass').hide();
                        $('#btn-back').fadeIn();
                        $('#return_msg').removeClass('alert-danger').addClass('alert-success').html(dados.mensagem).fadeIn();

                        setTimeout(function () {
                            window.location.href = 'logar.php';
                        }, 2000);
                    }
                }
            }, 'jSON');
        } else {
            $('#return_msg').removeClass('alert-success').addClass('alert-danger').html('Insira a senha e a confirmação da senha').fadeIn();
        }

    });
});