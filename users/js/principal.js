$(document).ready(function (){
    /* Popular combo com todos os CONSOLES
    ** @param select
    ** @param function - recebe o combobox que será preenchido
    */
    window.load_console_user = function(select){
        $.ajax({
            method:'POST',
            url: '../controllers/carregaConsole.php',
            dateType:'json',
            contentType: 'application/json'
        }).done(function(dados){
            if(dados != null){
                var consoles = $.parseJSON(dados);//transforma string em objeto
                var selectBox = select;
                
                $.each(consoles, function(key, value){
                   $('<option>').val(value.id_console).text(value.nome_console).appendTo(selectBox);//populando select
                });
            }
        });
    }

    /*
     *Função reload()
     *Carrega o conteudo das página com base no href passado
     * @param href = recebe o link da página
     */
	window.reload = function(href) {
        var content = $('#conteudo');               
        //content.html( '<img src="img/load.gif" alt="Loading..." class="img-responsive loading"/>' );
        
        $.ajax({
            url: href,
            success: function (response) {
               // window.setTimeout(function () {
                    content.html(response);
                //}, 1000);
            },
            error: function(error){
                content.html('<div class="error">Erro ao carregar a página! Tente novamente</div>');                
            }
        });
    }
     /*
     *Função first_load()
     *Carrega a primeira página ao entrar na dashboard
     */
    function first_load(){
        
        url = window.location.href;        

        var flag = url.indexOf('?') > -1;
        if(!flag){
            link = 'home.php';
        }else{

            res = url.split("=");
            link = res[1];
            link = link.replace("#","");
            
            if(!link){                
                link = $('#left_menu li:first').find('a').attr('href');
                link = link+'.php';
               
                $('#left_menu li:first').addClass('arrow_right');//ativa o link clicado
            }else{
                        
                $('#'+link).addClass('arrow_right');
                link = link+'.php';                
            }
        }
        reload(link);
    }
    first_load();//carregar uma página no load

    function addremoveActive(btn){
        $('#left_menu li').each(function(i){
            $('li:not(arrow_right)').removeClass('arrow_right'); //remover a classe arrow_right 
        });
        $('.container-menu .menu').each(function(i){
            $('li:not(arrow_right) > a').removeClass('arrow_right'); //remover a classe arrow_right 
        });
        $(btn).find('a').addClass('arrow_right');
    }

	$('.nav_op_left').bind('click', function(e){
		e.preventDefault();
        botao = $(this);
		if(botao.hasClass('arrow_right')){
		}else{
			var link = botao.find('a').attr('href');					
			link = link+'.php'; 
            
            addremoveActive(botao);						
			reload(link);	
		}
    });
    
    //carrega a página clicada no box principal
    $('.container-menu .menu').bind('click', function(e){
        e.preventDefault();
        botao = $(this);
        
        if($(this).hasClass('arrow_right')){}
        else{
            link = $(this).find('a').attr('href');
            addremoveActive(botao);
            reload(link);
        }        
    });

    /**************************************
     * INÍCIO
     * Funções NOTIFICAÇÃO
     **************************************/
    $("#notification, .toast_title").on("click", function(){
        $(".toast").toggle();
    });

    window.closenotice = function(){
        $("#response").fadeOut();
        $(".toast").fadeIn();
    }

    window.readnotice = function(){
       
        idnote = $("#btn-read").attr("name");
       
        $.ajax({
            url: "mensagens/readnotice.php",
            type: "POST",
            dataType:'json',
            data:'idnote='+ idnote,

            success: function (response) {                
                if(response.status == "1"){
                    $(".toast_id_"+idnote).fadeOut();
                    closenotice();
                    $(".toast").fadeIn(); 

                    quant = $(".qnt-notice").text();
                    quant = parseInt(quant);
                    if(quant>0){
                        quant = quant - 1;
                    }
                    $(".qnt-notice").html(quant);
                }
            },
            error: function(error){
                content.html('<div class="error">Erro ao carregar a página! Tente novamente</div>');                
            }
        });
    }
    
    //marcar notificações lidas
    $(".toast__close").on("click", function(){       
        idnote = $(this).attr("id");
        
        if(idnote != ""){
            $("#btn-read").attr("name", idnote);
            $("#response").fadeIn();
            $(".toast").toggle();
        }
    });

    /**************************************
     * FIM
     * Funções NOTIFICAÇÃO
     **************************************/    
    
     /** Controla os filtros */
	$("#menu-toggle, #close-menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	}); 
});