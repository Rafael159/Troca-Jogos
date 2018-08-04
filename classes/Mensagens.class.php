<?php

class Mensagens{

	protected $table = 'mensagens';
	//métodos
	private $id;
	private $cod_from;
	private $cod_to;
	private $mensagem;
	private $datahora;
	private $lido;

	//SET's
	public function setID($id){
		$this->id = $id;
	}
	public function setCodFrom($cod_from){
		$this->cod_from = $cod_from;
	}
	public function setCodTo($cod_to){
		$this->cod_to = $cod_to;
	}
	public function setMensagem($mensagem){
		$this->mensagem = $mensagem;
	}
	public function setLido($lido){
		$this->lido = $lido;
	}

	//GET's
	public function getID(){
		return $this->id;
	}
	public function getCodFrom(){
		return $this->cod_from;
	}
	public function getCodTo(){
		return $this->cod_to;
	}
	public function getMensagem(){
		return $this->mensagem;
	}
	public function getLido(){
		return $this->lido;
	}

	public function insertMessage(){

		$sql = "INSERT INTO $this->table (cod_from, cod_to, mensagem, datahora) VALUES(?, ?, ?, ?)";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindValue('1', $this->cod_from);
		$stmt->bindValue('2', $this->cod_to);
		$stmt->bindValue('3', $this->mensagem);
		$stmt->bindValue('4', date('Y-m-d H:i:s'));

		//return $sql;
		return $stmt->execute();

	}

	public function showMessage(){
		$sql = "SELECT * FROM $this->table WHERE cod_from = ? AND cod_to = ? OR cod_from = ? AND cod_to = ?";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindValue('1', $this->cod_from);
		$stmt->bindValue('2', $this->cod_to);
		$stmt->bindValue('3', $this->cod_to);
		$stmt->bindValue('4', $this->cod_from);		
		$stmt->execute();

		return $stmt->fetchAll();
	}

	public function updateMessageRead(){
		$sql = "UPDATE $this->table SET lido = 'sim' WHERE cod_from = ? AND cod_to = ?";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindValue('1', $this->cod_to);
		$stmt->bindValue('2', $this->cod_from);
		
		return $stmt->execute();
	}

	/*Função: Buscar as mensagens de acordo com o parâmetro
	** @param $lido - sim ou nao
	** @return @qtd - a quantidade de mensagens
	**/
	public function countMessageRead($lido){
		$sql = "SELECT m.* FROM mensagens m WHERE cod_from = ? AND cod_to = ?
		AND m.lido = '$lido'";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindValue('1', $this->cod_to);
		$stmt->bindValue('2', $this->cod_from);	

		if($stmt->execute()):
			$_data = $stmt->rowCount();
		endif;

		return $_data;
	}
}