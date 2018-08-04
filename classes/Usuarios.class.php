<?php
require_once 'CRUD.class.php';

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
	public function setCidade($cidade){
		$this->cidade = $cidade;
	}
	public function setEstado($estado){
		$this->estado = $estado;
	}
	public function setComplemento($complemento){
		$this->comple = $complemento;
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

		$sql  = "SELECT u.id_user,
				u.nomeUser, u.celular, u.telefone, u.rua, u.numero, u.cidade, u.estado, u.complemento, u.console
		 FROM $this->table as u WHERE id_user = :id";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id',$this->id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(); 

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

		$sql  = "INSERT INTO $this->table(nomeUser, emailTJ, senha, console, celular, telefone, cep, rua, numero, cidade, estado, tipousuario, complemento, status, logfirst, logusuario ) VALUES 
		(:nome, :email, :senha, :console, :celular, :telefone, :cep, :rua, :numero, :cidade, :estado, :tipousuario, :complemento, :status, :logfirst, :logusuario)";
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
		$stmt->bindParam(':cidade',$this->cidade);
		$stmt->bindParam(':estado',$this->estado);
		$stmt->bindParam(':tipousuario',$this->tipousuario);
		$stmt->bindParam(':complemento',$this->comple);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':logfirst', $this->logFirst);
		$stmt->bindParam(':logusuario', $this->logUsuario);

		return $stmt->execute();
	}

	public function update(){

		$sql = "UPDATE $this->table SET nome = :nome, emailTJ = :email, senha = :senha, data = :data, celular = :celular , telefone = :telefone
		rua = :rua, numero = :numero, cidade = :cidade , estado = :estado, complemento = :complemento, status = :status, id_console = :id_console WHERE id = :id";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':nome',$this->nome);
		$stmt->bindParam(':email',$this->email);
		$stmt->bindParam(':senha',$this->senha);
		$stmt->bindParam(':data',$this->data);
		$stmt->bindParam(':celular',$this->celular);
		$stmt->bindParam(':telefone',$this->telefone);
		$stmt->bindParam(':rua',$this->rua);
		$stmt->bindParam(':numero',$this->numero);
		$stmt->bindParam(':cidade',$this->cidade);
		$stmt->bindParam(':estado',$this->estado);
		$stmt->bindParam(':complemento',$this->comple);
		$stmt->bindParam(':status',$this->status);
		$stmt->bindParam(':id_console',$this->id_console);
		$stmt->bindParam(':id', $this->id);
		return $stmt->execute();

	}

	//exibir registro individual por EMAIL
	public function findEmail(){

		$sql  = "SELECT * FROM $this->table WHERE emailTJ = :email";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':email',$this->email);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/*
	 * Function: Fazer login usuário
	 */
	public function loginUser(){

		$sql = "SELECT * FROM $this->table WHERE emailTJ = :email AND senha = :senha";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':senha', $this->senha);
		$stmt->execute();

		try {			
			if($stmt->rowCount() == 1){
				return $stmt->fetchObject();
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}		
	}
}

?>