$(document).ready(function (){

	function slideIndex(){		
		//efeito horizontal
		camada = $('#slider ul li img');
		largura = camada.innerWidth();//recebe a largura da imagem
		altura =  camada.innerHeight()+30; // recebe a altura da imagem + 30px
		posiMain = $('#slider').offset().top;	//posição da div referente ao topo			
		posileft = camada.offset().left;		

		$("#prevId").hide();//esconde botão de voltar
	}

	/*esconder btn de navegação*/
	function hide(item){
		item.hide();
	}
	/*ANIMAÇÃO PARA CIMA*/
	function animate_up(){
		$("#slider ul").animate({
			marginTop:'+='+altura+'px'   //anima a imagem para cima proporcionalmente
		},function(){
			$("#nextBtn").show(); //após o primeiro clique o botão de anterior aparece
		positop = $("#slider ul").offset().top;
			if(positop >= posiMain){
				hide($("#prevId"));	//no ultimo , esconder botão de próximo								
			}				
		});
	}
	function animate_down(){
		$('#slider ul').animate({
			marginTop: '-='+altura+'px'
		},function(){
			$("#prevId").show();
			ultimo = $("#slider li:last").offset().top;
			
			if(ultimo <= posiMain){
				hide($("#nextBtn"));
			}
		});	
	}
	slideIndex();			

	$("#prevId").click(function(){
		animate_up();		
	});
	//sentido
	$("#nextBtn").click(function(){
		animate_down();
	});	
});