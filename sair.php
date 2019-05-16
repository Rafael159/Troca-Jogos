<!--
	*****SITE Restart Games						********
	*****Programador : RAFAEL ALVES CARDOSO     ********
	*****DATA: 06/03/2015                       ********
-->
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
	   <title>Finalizando sessões</title>
    </head>
<body>
	  <?php 
			 session_start();
			//  echo '<pre>';
			//  var_dump($_SESSION);

			//  echo $_SESSION['status'];
			//  die();
	  	   unset($_SESSION['emailTJ']);
	  	   unset($_SESSION['id_user']);
	  	   unset($_SESSION['nomeTJ']);
			 unset($_SESSION['status']);
			 
			 session_destroy();
	  	   sleep(1);
	  	   header("Location:index.php");	  	 
	  ?>
</body>
</html>