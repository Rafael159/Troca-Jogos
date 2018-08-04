<?php
class JogoCategoria extends CRUD{
	protected $table = 'jogocategoria';

	private $id_jogo;
	private $id_categoria;

	//sets
	public function setJogoID($id_jogo){
		$this->id_jogo = $id_jogo;
	}
	public function setCategoriaID($id_categoria){
		$this->id_categoria = $id_categoria;
	}
	//gets
	public function getJogoID(){
		return $this->id_jogo;
	}
	public function getCategoriaID(){
		return $this->id_categoria;
	}

	public function insert(){
		
		$sql = "INSERT INTO $this->table (jogo_id, categoria_id) VALUES (:id_jogo, :id_categoria)";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id_jogo', $this->id_jogo);
		$stmt->bindParam(':id_categoria', $this->id_categoria);
		return $stmt->execute();

	}

	/* Função Buscar todas as categorias do jogo 
	   @return array com as categorias
	*/
	public function findAllByID(){

		$sql = "SELECT * FROM $this->table WHERE jogo_id = :id_jogo";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id_jogo', $this->id_jogo);
		
		$stmt->execute();
		return $stmt->fetchAll();

	}

	/* Função Buscar todas as categorias do jogo 
	   @return array com as categorias
	*/
	public function findByGameGenre(){

		$sql  = "SELECT * FROM $this->table WHERE (jogo_id = :id_jogo) AND (categoria_id = :id_categoria) ";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id_jogo', $this->id_jogo);
		$stmt->bindParam(':id_categoria', $this->id_categoria);
			    
	    $stmt->execute();
	    return $stmt->rowCount();

	}

	/*
	 * Função: Deletar categoria do jogo
	*/
	public function delete(){

		$sql  = "DELETE FROM $this->table WHERE (jogo_id = :id_jogo) AND (categoria_id = :id_categoria) ";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id_jogo', $this->id_jogo);
		$stmt->bindParam(':id_categoria', $this->id_categoria);		
		$stmt->execute();

		return $stmt;

	}

	public function update(){}
}
?>