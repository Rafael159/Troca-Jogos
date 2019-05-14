<?php

spl_autoload_register(function($classe) {
	 require('classes/'.$classe.'.class.php'); /*chama a classe automaticamente*/
 });

include_once('../../classes/BD.class.php');//conexão com o banco de dados

$email = trim($_POST['email']);
$senha = trim($_POST['senha']);

if(empty($email) || empty($senha)){
	echo "O email e a senha devem ser preenchidos !";
}else{
	$query = "SELECT * FROM usuarios WHERE emailTJ = '$email' AND status = 'sim'";
	$stmt = @BD::conn()->prepare($query);		

	if($stmt->execute()){
		$dados = $stmt->fetchObject();		
		if($stmt->rowCount() == 1){
			$hash = $dados->senha;
			if (crypt($senha, $hash) === $hash) {
				/*se true, será iniciado as SESSIONS*/		
				session_start();
				$_SESSION['emailTJ'] = $_POST['email'];
				$_SESSION['nomeTJ'] = $dados->nomeUser;

				if($dados->status == 1){
					echo $msg = 
						'<script type="text/javascript">
							window.location.href=("../admin/admin.php");
						</script>';
				}else{
					echo $msg =
						'<script type="text/javascript">
							window.location.href=("users/myarea.php");
						</script>';
				}
			}else{
				echo "Email e/ou senha incorretos";
			}
		}else{
			echo "Email não encontrado. Verifique seu email e tente novamente";
		}
	}else{
		echo "Falha ao conectar no servidor";
	}
}
?>