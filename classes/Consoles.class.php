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
		return $this->nome_console;
	}

	public function consoleById($idconsole){
		$sql = "SELECT id_console, nome_console FROM $this->table WHERE id_console = :id_console";
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
	
	public function showAll($dados=array()){

		if(array_key_exists("id", $dados)) $id = $dados['id'];
		if(array_key_exists("console", $dados)) $console = $dados['console'];		
		
		$where = array();
		if(count($dados) > 0):
			if(isset($id)) array_push($where, "id_console = $id ");
			if(isset($console)) array_push($where, "nome_console LIKE '%$console%' ");
		endif;		
		$query = "SELECT * FROM $this->table";

		if(count($where) > 0):		
			$query .= ' WHERE '.implode( ' AND ',$where );//add filtros na QUERY
		endif;
						
		$stmt = @BD::conn()->prepare($query);

		try{
			$stmt->execute();
			return $stmt->fetchAll();
		}catch (Exception $e) {
			return false;
		}
		
		
	}

	public function listarTodos(){

		$sql = "SELECT * FROM $this->table";		
		$stmt = @BD::conn()->prepare($sql);

		try{
			$stmt->execute();
			return $stmt->fetchAll();
		}catch (Exception $e) {
			return false;
		}

	}

	//inserir consoles no banco de dados
	public function insert(){
		
	}

	//atualizar consoles
	public function update(){
		
	}		
}
?>