<?php
	class Generos extends Crud{

		protected $table = 'genero';

		private $id;
		private $nome;

		public function setId($id){
			$this->id = $id;
		}
		public function setNome($nome){
			$this->nome = $nome;
		}

		public function getId(){
			return $this->id;
		}
		public function getNome(){
			return $this->nome;
		}

		public function insert(){

			$sql = 'INSERT INTO $this->table(id, nome) VALUES (:id, :nome)';
			$stmt = @BD::con()->prepare($sql);
			$stmt->bindParam(':id', $this->id);
			$stmt->bindParam(':nome', $this->nome);

			return $stmt->execute();
		}

		public function update(){
			
		}

		public function findGenreByID(){

			$sql = "SELECT * FROM $this->table WHERE id = :id_genre";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':id_genre', $this->id);
			$stmt->execute();
			$retorno = $stmt->fetchObject();
			
			$this->setNome($retorno->nome);
			return $retorno;
		}

	}
?>