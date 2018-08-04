<?php

final class Consoles extends Crud{

	protected $table = 'console';

	private $id_console;
	private $nome_console;

	//sets
	public function setIdConsole($id_console){
		$this->id_console = $id_console;
	}
	public function setNomeConsole($nome_console){
		$this->nome_console = $nome_console;
	}
	public function getNomeConsole(){
		return $nome_console;
	}

	public function consoleById($idconsole){
		$sql = "SELECT nome_console FROM $this->table WHERE id_console = :id_console";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindValue(':id_console',$idconsole);	

		try{
			$stmt->execute();
			$result = $stmt->fetchAll();
			return $result;
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}
	/*buscar a categoria do jogo pelo id*/
	public function listarCategorias($id){

		$sql = "SELECT * FROM $this->table WHERE id_console = $id";		
		$stmt = @BD::conn()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();

	}
	
	public function listarTodos(){

		$sql = "SELECT * FROM $this->table";		
		$stmt = @BD::conn()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();

	}

	//inserir consoles no banco de dados
	public function insert(){
		
	}

	//atualizar consoles
	public function update(){
		
	}		
}
?>