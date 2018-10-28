$(document).ready(function(){
    
    $('button[name=btn-recover]').on('click', function(ev){
        ev.preventDefault();
        
        email = $('input[name=email_recover]').val();
        
        if(email.length > 1){
            $.ajax({
                method:'POST',
                url: 'verifica.php',
                dataType:'json',
                data: {email: email, tipo: 'recuperar'},
                success: function(dados){
                        console.log(dados);            
                    /*if(dados.status == '0'){
                        console.log(dados);//error
                    }else{
                        console.log(dados);
                    }*/
                }
    
            });
        }else{
            alert('nada');
        }
    });

});