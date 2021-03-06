<?php
require_once 'Crud.class.php';

class Usuarios extends Crud{
	protected $table = 'usuarios'; //definindo a tabela
	private $id;
	private $nome;
	private $email;
	private $senha;	
	private $celular;
	private $telefone;
	private $cep;
	private $rua;	
	private $numero;
	private $bairro;
	private $cidade;
	private $estado;
	private $complemento;
	private $console;
	private $tipoUsuario;
	private $status;
	private $logFirst;
	private $logUsuario;

	public function setIdUser($id){
		$this->id = $id;
	}
	public function setNome($nome){
		$this->nome = $nome;
	}
	public function setEmail($email){
		$this->email = $email;
	}
	public function setSenha($senha){
		$this->senha = $senha;
	}	
	public function setCelular($celular){
		$this->celular = $celular;
	}
	public function setTelefone($telefone){
		$this->telefone = $telefone;
	}
	public function setCEP($cep){
		$this->cep = $cep;
	}
	public function setRua($rua){
		$this->rua = $rua;
	}
	public function setNumero($numero){
		$this->numero = $numero;
	}
	public function setBairro($bairro){
		$this->bairro = $bairro;
	}
	public function setCidade($cidade){
		$this->cidade = $cidade;
	}
	public function setEstado($estado){
		$this->estado = $estado;
	}
	public function setComplemento($complemento){
		$this->complemento = $complemento;
	}
	public function setConsole($console){
		$this->console = $console;
	}
	public function setTipoUsuario($tipousuario){
		$this->tipousuario = $tipousuario;
	}
	public function setStatus($status){
		$this->status = $status;
	}
	public function setLogFirst($logFirst){
		$this->logFirst = $logFirst;
	}
	public function setLogUsuario($logUsuario){
		$this->logUsuario = $logUsuario;
	}
	//GET'S
	public function getSenha(){
		return $this->senha;
	}

	public static function getUsuario($field = null){
		if(!isset($_SESSION)) session_start();
			
		if(!isset($_SESSION['usuario'])) return false;		
		$usuario = unserialize($_SESSION['usuario']);
		
		if(is_null($field)){
			return $usuario;
		}

		return (isset($usuario->$field)) ? $usuario->$field : false;
	}

	public static function limpaCep($cep){
		$newCep = (isset($cep)) ? trim($cep) : '';
		if(!empty($newCep)):
			$notAllowed = array("-", "'");
			foreach($notAllowed as $key => $cp){
				$newCep = str_replace($cp, '', $newCep);
			}
			return $newCep;
		endif;
	}

	//exibir registro individual por ID
	public function findRegister(){

		$sql  = "SELECT u.id_user, u.nomeUser, u.emailTJ, u.celular, u.telefone, u.cep, u.rua, u.numero, u.cidade, u.bairro,  u.estado, u.complemento, u.console
		 		FROM $this->table as u 
				WHERE u.id_user = :id";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id',$this->id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchObject();

	}

	//exibir registro individual por ID
	public function getNameByID($id){
		$id = (isset($id)) ? $id : '';
		$id = (int)$id;

		$sql  = "SELECT u.nomeUser
				 FROM $this->table as u 
				 WHERE id_user = :id";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id',$id,PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 

	}

	public function insert(){

		$sql  = "INSERT INTO $this->table(nomeUser, emailTJ, senha, console, celular, telefone, cep, rua, numero, bairro, cidade, estado, complemento, tipousuario, status, logfirst, logusuario) VALUES 
		(:nome, :email, :senha, :console, :celular, :telefone, :cep, :rua, :numero, :bairro, :cidade, :estado,:complemento, :tipousuario, :status, :logfirst, :logusuario)";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':nome',$this->nome);
		$stmt->bindParam(':email',$this->email);
		$stmt->bindParam(':senha',$this->senha);
		$stmt->bindParam(':console',$this->console);
		$stmt->bindParam(':celular',$this->celular);
		$stmt->bindParam(':telefone',$this->telefone);
		$stmt->bindParam(':cep', $this->cep);
		$stmt->bindParam(':rua',$this->rua);
		$stmt->bindParam(':numero',$this->numero);
		$stmt->bindParam(':bairro',$this->bairro);
		$stmt->bindParam(':cidade',$this->cidade);
		$stmt->bindParam(':estado',$this->estado);
		$stmt->bindParam(':complemento', $this->complemento);
		$stmt->bindParam(':tipousuario', $this->tipousuario);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':logfirst', $this->logFirst);
		$stmt->bindParam(':logusuario', $this->logUsuario);

		if($stmt->execute()){
			return @BD::conn()->lastInsertId();
		}else{
			return false;
		}
	}

	public function update(){

		$sql = "UPDATE $this->table SET nomeUser = :nome, emailTJ = :email, celular = :celular, telefone = :telefone, cep = :cep,
		rua = :rua, numero = :numero, bairro = :bairro, cidade = :cidade , estado = :estado, complemento = :complemento, console = :console, logusuario = :logusuario WHERE id_user = :id";
		
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':nome',$this->nome);
		$stmt->bindParam(':email',$this->email);
		//$stmt->bindParam(':senha',$this->senha);
		//$stmt->bindParam(':data',$this->data);
		$stmt->bindParam(':celular',$this->celular);
		$stmt->bindParam(':telefone',$this->telefone);
		$stmt->bindParam(':cep',$this->cep);
		$stmt->bindParam(':rua',$this->rua);
		$stmt->bindParam(':numero',$this->numero);
		$stmt->bindParam(':bairro',$this->bairro);
		$stmt->bindParam(':cidade',$this->cidade);
		$stmt->bindParam(':estado',$this->estado);
		$stmt->bindParam(':complemento',$this->complemento);
		//$stmt->bindParam(':status',$this->status);
		$stmt->bindParam(':console',$this->console);
		$stmt->bindParam(':logusuario', $this->logUsuario);
		$stmt->bindParam(':id', $this->id);

		return $stmt->execute();

	}

	//Mudar o status do usuário
	public function changeStatus($status, $id){
		$sql = "UPDATE $this->table SET status = '$status' WHERE id_user = $id";
		$stmt = @BD::conn()->prepare($sql);
		if($stmt->execute()){
			return true;
		}
	}

	//atualizar senha
	public function updatePass($email, $senha){
		$sql = "UPDATE $this->table SET senha = '$senha' WHERE emailTJ = '$email'";
		$stmt = @BD::conn()->prepare($sql);
		if($stmt->execute()){
			return true;
		}else return false;
	}

	//exibir registro individual
	public function getRegister($queries = array()){		
		$id = (array_key_exists("id", $queries)) ? $queries['id'] : ''; 
		$email = (array_key_exists("email", $queries)) ? $queries['email'] : '';		
		$tipousuario = (array_key_exists("tipousuario", $queries)) ? $queries['tipousuario'] : '';		
		$status = (array_key_exists("status", $queries)) ? $queries['status'] : '';		
		$_where = array();

		if($id) array_push($_where, " id_user = :id ");
		if($email) array_push($_where, " emailTJ = :email ");
		if($tipousuario == "0" || $tipousuario == "1") array_push($_where, " tipousuario = :tipousuario");

		$w = '';
		if(count($_where) > 0){
			foreach($_where as $key=>$v){
				$w .= ' AND '.$v;
			}
		}
		$situacao = 'sim';
		if($status) $situacao = $status;
		$where = " WHERE status = '$situacao'";
		
		$sql  = "SELECT c.*, u.* FROM `usuarios` u inner join `console` c on(u.console = c.id_console) $where $w";
		
		$stmt = @BD::conn()->prepare($sql);
		if($id) $stmt->bindParam(':id', $id);
		if($email) $stmt->bindParam(':email', $email);
		if($tipousuario == "0" || $tipousuario == "1") $stmt->bindParam(':tipousuario', $tipousuario);
		$stmt->execute();
		return $stmt->fetchAll();		
	}

	public static function getRegisterHelper($queries = array()){
		$contar = (array_key_exists("contar", $queries)) ? $queries['contar'] : ''; 
		
		$rows = new Usuarios;
		$row = $rows->getRegister($queries);
		
		//if(count($row) == 0) return false;
		if($contar == "sim") return count($row);
		return $row;
	}

	//exibir registro individual
	public function findEmail($queries = array()){		
		
		$id = (array_key_exists("id_user", $queries)) ? $queries['id_user'] : ''; 
		$email = (array_key_exists("email", $queries)) ? $queries['email'] : '';		

		$_where = array();
		if($id) array_push($_where, " id_user = :id ");
		if($email) array_push($_where, " emailTJ = :email ");
		
		$w = '';
		if(count($_where) > 0){

			foreach($_where as $key=>$v){
				$w .= ' AND '.$v;
			}

		}

		$where = " WHERE status = 'sim'";
		
		$sql  = "SELECT * FROM $this->table $where $w";
		
		$stmt = @BD::conn()->prepare($sql);
		if($id) $stmt->bindParam(':id', $id);
		if($email) $stmt->bindParam(':email', $email);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/*
	 * Function: Fazer login usuário
	 */
	public function loginUser(){

		$sql = "SELECT * FROM $this->table WHERE emailTJ = :email AND senha = :senha AND status = 'sim'";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':senha', $this->senha);
		$stmt->execute();

		try {			
			if($stmt->rowCount() == 1){
				return $stmt->fetch();
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}		
	}
}

?>