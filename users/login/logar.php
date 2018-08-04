<html>
	<head>
	<!--CHAMADA JAVASCRIPT-->		
	<script type="text/javascript" src="../javascript/jquery.js"></script>
	
	<!--CHAMADA CSS-->
	<link rel="stylesheet" type="text/css" href="css/layout.css"/>

	<title>Entre agora mesmo !</title>
	<script>
		$(document).ready(function (){
			$("#enviar").click(function (){
				
				var email = $("#email").val();
				var senha = $("#senha").val();

				$.post('verifica.php',{email:email, senha:senha},function(dados){
					$("#result").fadeIn().html(dados);
					$("#result").delay(2500).fadeOut();		
				});

			});
		});
	</script>
	</head>
<body>
	<div id="top">
		<a href="../index.php"><img src="../imagens/backgrounds/logo.png" alt="TrocaJogos"></a>
	</div>
	<div id="box_logar">
		<form method="POST" action="" name="form-acesso" class="form-acesso">			
			<p>
				<label for="email_login">Email:</label>
				<input type="text" name="email" id="email" placeholder="nome@exemplo.com"/>
			</p>
			<p>
				<label for="senha_login">Senha:</label>
				<input type="password" name="senha" id="senha" placeholder="*************"/>
			</p>
			<p>
				<label>
					<img src="img/seta.png" id="enviar" />									
				</label>	
			</p>
						
			<p>			
				<label id="links-login">
					<a href="../index.php">Cancelar</a>
					<a href="#user-cadastrar">Esqueceu a senha?</a>
				</label>								
			</p>
			<div id="result"></div>	
		</form>
	</div>
</body>
</html>