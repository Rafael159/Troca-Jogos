<?php
/**
    * Função CRUD DAS IMAGENS
    * @author Rafael Alves Cardoso
    * @param String $idConsole Id do console ao qual a imagem pertence
    * @param String $nome Nome do jogo que a imagem será anexada
    * @param String $imagem Nome da imagem
    * @return array
*/	
class Imagens extends Crud{
	protected $table = 'imagens';

	private $idimg;
	private $idConsole;
	private $nome; 
	private $imagem;

	//SET'S
	public function setIdImagem($idimg){
		$this->idimg = $idimg;
	}
	public function setIdConsole($idconsole){
		$this->idconsole = $idconsole;
	}
	public function setNome($nome){
		$this->nome = $nome;
	}
	public function setImagem($imagem){
		$this->imagem = $imagem;
	}

	//GET'S
	public function getIdImg(){
		return $idimg;
	}
	public function getIdConsole(){
		return $idconsole;
	}
	public function getNomeImagem(){
		return $nomeimagem;
	}
	public function getImagem(){
		return $imagem;
	}

	public function insert(){
		
		$sql = "INSERT INTO $this->table (id_console, nome, imagem) VALUES (:id_console, :nome, :imagem)";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id_console', $this->idconsole);
		$stmt->bindParam(':nome', $this->nome);
		$stmt->bindParam(':imagem', $this->imagem);
		return $stmt->execute();

	}

	//atualizar jogos
	public function update(){
		$sql = "UPDATE $this->table SET nome = :nome WHERE id_img = :id";
		$stmt = @BD::conn()->prepare($sql);		
		$stmt->bindParam(':nome', $this->nome);
		$stmt->bindParam(':id', $this->idimg);
		return $stmt->execute();
	}

	/*buscar imagem pelo nome
	 *@param 
	*/
	public function findPhoto(){
		$sql = "SELECT * FROM $this->table WHERE imagem = :imagem";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':imagem', $this->imagem);
		$stmt->execute();
		return $stmt->fetchAll();
	}

}
	
?>