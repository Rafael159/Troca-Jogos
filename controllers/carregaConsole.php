<?php
	function __autoload($classe){
		require ('..\classes/'.$classe.'.class.php');
	}

	@BD::conn();//conexão com o banco de dados
    $console = new Consoles();//instancia classe consoles

    $allConsoles = $console->listarTodos();
    echo json_encode($allConsoles); //método que lista todos os consoles  
          
?>