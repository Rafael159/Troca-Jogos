$(document).ready(function(){
    /*@param idlogado - id do user logado*/

    //pegar o contato
    $(".chat").on("click", function(){
        user = $(this).attr("usuario");
        chat_id = $(this).attr("id");
        separarId = chat_id.split("_");
        idUser = separarId[1];
        
        id = (idUser) ? idUser : 0;
        //idlogado = (idlogado) ? idlogado : 0;

        $.ajax({
            method:'POST',
            url: '../controllers/chat.php',
            data: {
                para: id, 
                acao: 'get'
            }
        }).done(function(dados){
            if(dados !== ""){
                if(user){
                    $("#talkto").html(user);
                    $(".chat_begin").css("display", "block");
                }
                $(".mensagens #chat_msg").html(dados);
            }else{
                $(".mensagens #chat_msg").html("Nada encontrado");
                $(".chat_begin").css("display", "none");
            }            
        });
    });
});