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
	private $idconsole;
	private $nome; 
	private $imagem;
	private $datacriacao;

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
	public function setDatacriacao($datacriacao){
		$this->datacriacao = $datacriacao;
	}

	//GET'S
	public function getIdImg(){
		return $this->idimg;
	}
	public function getIdConsole(){
		return $this->idconsole;
	}
	public function getNomeImagem(){
		return $this->nomeimagem;
	}
	public function getImagem(){
		return $this->imagem;
	}
	public function getDatacriacao(){
		return $this->datacriacao;
	}

	public function insert(){
		
		$sql = "INSERT INTO $this->table (id_console, nome, imagem, datacriacao) VALUES (:id_console, :nome, :imagem, :datacriacao)";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id_console', $this->idconsole);
		$stmt->bindParam(':nome', $this->nome);
		$stmt->bindParam(':imagem', $this->imagem);
		$stmt->bindParam(':datacriacao', $this->datacriacao);
		return $stmt->execute();

	}

	/**
	 * Função: Atualizar imagens
	 **/
	public function update(){
		$sql = "UPDATE $this->table SET nome = :nome WHERE id_img = :id";
		$stmt = @BD::conn()->prepare($sql);		
		$stmt->bindParam(':nome', $this->nome);
		$stmt->bindParam(':id', $this->idimg);
		return $stmt->execute();
	}
	/**
	* Função: Deletar imagem
	 **/
	public function delete(){
		$sql  = "DELETE FROM $this->table WHERE (id_img = :id_img)";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id_img', $this->idimg);			
		$stmt->execute();
		return $stmt;
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

	//listagem das imagens
	public function getImage($queries = array()){
		$id = (array_key_exists("id_img", $queries)) ? $queries['id_img'] : ''; 
		$console = (array_key_exists("id_console", $queries)) ? $queries['id_console'] : '';		
		$nome = (array_key_exists("nome", $queries)) ? $queries['nome'] : '';		
		$order = array_key_exists("order", $queries) ? $queries['order'] : '';
		
		$_where = array();
		if($id) array_push($_where, " id_img = :id ");
		if($console) array_push($_where, " id_console = :console ");
		if($nome) array_push($_where, " nome = :nome ");
		
		$w = '';
		if(count($_where) > 0){
			foreach($_where as $key=>$v){
				$w .= ' AND '.$v;
			}
		}

		$where = " WHERE c.id_console = i.id_console";
		$ordem = "ORDER BY i.id_img ASC";
		if($order) $ordem = $order;

		$sql  = "SELECT i.*, c.* FROM `imagens` i, `console` c $where $w $ordem";

		$stmt = @BD::conn()->prepare($sql);

		if($id) $stmt->bindParam(':id', $id);
		if($console) $stmt->bindParam(':console', $console);
		if($nome) $stmt->bindParam(':nome', $nome);

		$stmt->execute();
		return $stmt->fetchAll();
	}

	private function getImageHelper($queries = array()){
		$rows = new Imagens();
		return $rows->getImage($queries);

	}

}
	
?>