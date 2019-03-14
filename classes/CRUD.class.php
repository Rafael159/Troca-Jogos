<?php
	require_once 'BD.class.php';

	abstract class Crud extends BD{

		protected $table;

		abstract public function insert();
		abstract public function update();

		//exibir registro individual por ID
		public function find($id){

			$sql  = "SELECT * FROM $this->table WHERE id = :id";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':id',$id, PDO::PARAM_INT);
			$stmt->execute();
			return  $stmt->fetchAll(); 

		}

		//exibir todos os registros
		public function findAll(){

			$sql  = "SELECT * FROM $this->table";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->execute();
			$stmt->rowCount();
			return $stmt->fetchAll();

		}

		//exibir todos os registros com LIMIT
		public function findAllByLimit($qtd){

			$sql  = "SELECT * FROM $this->table LIMIT $qtd";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->execute();
			$stmt->rowCount();
			return $stmt->fetchAll();

		}

		//exibir todos os registros na ordem descrescente 
		public function findAllDesc(){

			$sql  = "SELECT * FROM $this->table ORDER BY id DESC";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();

		}

		//deletar registro pelo id
		public function delete(){
			
			// $sql  = "DELETE FROM $this->table WHERE $campo = :id";
			// $stmt = @BD::conn()->prepare($sql);
			// $stmt->bindParam(':id',$id, PDO::PARAM_INT);
			// return $stmt->execute();

		}

		public function consulta($sql){

			$stmt = @BD::conn()->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll();
			
		}

	}
?>