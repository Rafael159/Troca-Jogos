<?php
  
    spl_autoload_register(function($classe) {
        require('../classes/'.$classe.'.class.php');
    });
    $user = new Usuarios();	

    $nome = (isset($_POST['nome'])) ? trim($_POST['nome']) : '';
    $celular = (isset($_POST['celular'])) ? trim($_POST['celular']) : '';
    $telefone = (isset($_POST['telefone'])) ? trim($_POST['telefone']) : '';
    $email = (isset($_POST['email'])) ? trim($_POST['email']) : '';
    $senha = (isset($_POST['senha'])) ? trim($_POST['senha']) : '';
    $conf_senha = (isset($_POST['conf_senha'])) ? trim($_POST['conf_senha']) : '';
    $console = (isset($_POST['console'])) ? $_POST['console'] : '';
    $cep = (isset($_POST['cep'])) ? $_POST['cep'] : '';
    $rua = (isset($_POST['rua'])) ? trim($_POST['rua']) : '';
    $numero = (isset($_POST['numero'])) ? trim($_POST['numero']) : '';
    $bairro = (isset($_POST['bairro'])) ? trim($_POST['bairro']) : '';
    $cidade = (isset($_POST['cidade'])) ? trim($_POST['cidade']) : '';    
    $estado = (isset($_POST['estado'])) ? trim($_POST['estado']) : '';
    $complemento = (isset($_POST['complemento'])) ? trim($_POST['complemento']) : '';	
    $tipo = (isset($_POST['tipousuario'])) ? $_POST['tipousuario'] : 0;

    session_start();

    $retorno = array();
    /*if(!$_SESSION):
        $retorno = array('status'=>1, 'mensagem'=>'Ocorreu um erro. Tente novamente');
        echo json_encode($retorno);
        exit();
    endif;*/

    $id = (isset($_SESSION['id_user'])) ? (int)$_SESSION['id_user'] : 0;

    if($id==0): 
        $retorno = array('status'=>1, 'mensagem'=>'Ocorreu um erro. Tente novamente');
        echo json_encode($retorno);
        exit();
    endif;

    if(empty($nome)):
		$retorno = array('status'=>'0', 'mensagem'=>'Campo recomendado! Insira seu nome');
		echo json_encode($retorno);
		exit();
	endif;

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
		$retorno = array('status'=>'0', 'mensagem'=>'Email incorreto! Insira um email válido');
		echo json_encode($retorno);
		exit();
	endif;

    $user->setEmail($email);
    $queries = array();
    $queries['id'] = $id;
	$_row = $user->findEmail($queries);
	$qtd=count($_row);

	if(count($_row) == "1"):
		$retorno = array('status'=>'0', 'mensagem'=>'Email já existe, por favor insira outro');
		echo json_encode($retorno);
		exit();		
	endif;
	if(empty($celular) && empty($telefone)):
		$retorno = array('status'=>'0', 'mensagem'=>'Informe pelo menos um telefone: celular ou fixo');
		echo json_encode($retorno);
		exit();
    endif;
    if(empty($console) || !is_numeric($console)):
		$retorno = array('status'=>'0', 'mensagem'=>'Por favor informe um console');
		echo json_encode($retorno);
		exit();
    endif;
    
    $cep = $user::limpaCep($cep);
    
    $user->setNome($nome);
    $user->setEmail($email);
    //$user->setSenha($senha);
    $user->setCelular($celular);
    $user->setTelefone($telefone);
    $user->setConsole($console);
    $user->setCEP($cep);
    $user->setRua($rua);
    $user->setNumero($numero);
    $user->setBairro($bairro);
    $user->setCidade($cidade);
    $user->setEstado($estado);
    $user->setComplemento($complemento);
    //$user->setStatus('sim');
    //$user->setTipoUsuario((int)$tipo);
    //$user->setLogFirst(date('Y-m-d H:i'));
    $user->setLogUsuario(date('Y-m-d H:i'));
    $user->setIdUser($id);
    
    
    if(!$user->update()):
        $retorno = array('status'=>'0', 'mensagem'=>'Ocorreu algum erro! Tente novamente mais tarde');
        echo json_encode($retorno);
        exit();
    else:
        $retorno = array('status'=>'1', 'mensagem'=>'Cadastro atualizado com sucesso');
        echo json_encode($retorno);
    endif;
?>