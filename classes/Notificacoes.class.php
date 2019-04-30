<?php
class Notificacoes{
    protected $table = 'notificacoes';

    private $id;
    private $titulo;
    private $tipo;
    private $mensagem;
    private $receptor;
    private $lido;
    private $dataalerta;

    public function setID($id){
        $this->id = $id;
    }
    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }
    public function setTipo($tipo){
        $this->tipo = $tipo;
    }
    public function setMensagem($mensagem){
        $this->mensagem = $mensagem;
    }
    public function setReceptor($receptor){
        $this->receptor = $receptor;
    }
    public function setLido($lido){
        $this->lido = $lido;
    }
    public function setDataalert($dataalerta){
        $this->dataalerta = $dataalerta;
    }
    
    public function getID(){
        return $this->id;
    }
    public function getTitulo(){
        return $this->titulo;
    }
    public function getTipo(){
        return $this->tipo;
    }
    public function getMensagem(){
        return $this->mensagem;
    }
    public function getReceptor(){
        return $this->receptor;
    }
    public function getLido(){
        return $this->lido;
    }
    public function getDataalerta(){
        return $this->dataalerta;
    }

    public function insertNotificacao(){

		$sql = "INSERT INTO $this->table (titulo, tipo, mensagem, receptor, lido, dataalerta) 
                VALUES(:titulo, :tipo, :mensagem, :receptor, :lido, :dataalerta)";
        //preparar SQL
        $stmt = @BD::conn()->prepare($sql);
        //setar valores        
		$stmt->bindParam(':titulo', $this->titulo);
		$stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':mensagem', $this->mensagem);
        $stmt->bindParam(':receptor', $this->receptor);
        $stmt->bindParam(':lido', $this->lido);
		$stmt->bindParam(':dataalerta', $this->dataalerta);

		return $stmt->execute();
    }
    
    public function updateNotificacao(){
        $sql = "UPDATE $this->table SET (titulo = :titulo, tipo = :tipo, mensagem = :mensagem, receptor = :receptor, lido = :lido, dataalerta = :dataalerta) WHERE id = :id";
        //preparar SQL        
        $stmt = @BD::conn()->prepare($sql);
        //setar valores
        $stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':titulo', $this->titulo);
		$stmt->bindParam(':tipo', $this->tipo);
		$stmt->bindParam(':mensagem', $this->mensagem);
		$stmt->bindParam(':receptor', $this->receptor);
		$stmt->bindParam(':lido', $this->lido);
		$stmt->bindParam(':dataalerta', $this->dataalerta);
        
        return $stmt->execute();
    }

    public function getNotificacoes($queries = array()){
        $id = (array_key_exists("id", $queries)) ? $queries["id"] : "";
        $titulo = (array_key_exists("titulo", $queries)) ? $queries["titulo"] : "";
        $tipo = (array_key_exists("tipo", $queries)) ? $queries["tipo"] : "";
        $receptor = (array_key_exists("receptor", $queries)) ? $queries["receptor"] : "";
        $lido = (array_key_exists("lido", $queries)) ? $queries["lido"] : "";
        $dataalerta = (array_key_exists("dataalerta", $queries)) ? $queries["dataalerta"] : "";
		$order = array_key_exists("order", $queries) ? $queries['order'] : '';       

        $_where = array();

        if($id) array_push($_where, " id = $id");
        if($titulo) array_push($_where, " titulo = '$titulo'");
        if($tipo) array_push($_where, " tipo = '$tipo'");
        if($receptor) array_push($_where, " receptor = $receptor");
        if($lido) array_push($_where, " lido = '$lido'");
        if($dataalerta) array_push($_where, " dataalerta = '$dataalerta'");

        $w = '';
		if(count($_where) > 0){
			foreach($_where as $key=>$v){
				$w .= ' AND '.$v;
			}
		}

		$where = " WHERE excluido = 'nao'";
		$ordem = "ORDER BY id DESC";
		if($order) $ordem = $order;

		$sql  = "SELECT * FROM $this->table $where $w $ordem";
		
		$stmt = @BD::conn()->prepare($sql);
        
		$stmt->execute();
		return $stmt->fetchAll();
    }

    public static function contarNotificacoes($queries = array()){        
        $rows = new Notificacoes;
        $row = $rows->getNotificacoes($queries);
        
        return count($row);
    }
}

?>