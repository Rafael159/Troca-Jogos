<?php
/**
 * Função: Manipular as interações das amizades
 * @author Rafael Alves Cardoso
 * @param $id - ID da amizade
 * @param $whoSent - ID do usuário que manda o convite de amizade
 * @param $whoAccepted - ID do usuário que recebe o convide de amizade
 * @param $status - Status da amizade - Não ativo como padrão
 * @param $dataativacao - Data da ativação
 * @param $excluido - Variável que determina se o registro está excluido ou não
 */

class Friendships{
    protected $table = 'friendships';

	private $id;
	private $whoSent;
	private $whoAccepted; 
	private $status;
	private $dataativacao;
    private $excluido;
    
    //SET'S
    public function setId($id){
        $this->id = $id;
    }
    public function setWhoSent($whoSent){
        $this->whoSent = $whoSent;
    }
    public function setWhoAccepted($whoAccepted){
        $this->whoAccepted = $whoAccepted;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function setDataAtivacao($dataativacao){
        $this->dataativacao = $dataativacao;
    }
    public function setExcluido($excluido){
        $this->excluido = $excluido;
    }
    //GET'S 
    public function getId(){
        return $this->id;
    }
    public function getWhoSent(){
        return $this->whoSent;
    }
    public function getWhoAccepted(){
        return $this->whoAccepted;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getDataAtivacao(){
        return $this->dataativacao;
    }
    public function getExcluido(){
        return $this->excluido;
    }

    public function insert(){
		
		$sql = "INSERT INTO $this->table (who_sent, who_accepted, status, dataativacao, excluido) 
        VALUES (:who_send, :who_accepted, :status, :dataativacao, :excluido)";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':who_sent', $this->whoSent);
		$stmt->bindParam(':who_accepted', $this->whoAccepted);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':dataativacao', $this->dataativacao);
		$stmt->bindParam(':excluido', $this->excluido);
		return $stmt->execute();

    }
    
    public function update(){
        $sql = "UPDATE $this->table SET (who_sent = :who_sent, who_accepted = :who_accepted, status = :status, dataativacao = :dataativacao, excluido = :excluido) WHERE id = :id";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':who_sent', $this->whoSent);
		$stmt->bindParam(':who_accepted', $this->whoAccepted);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':dataativacao', $this->dataativacao);
		$stmt->bindParam(':excluido', $this->excluido);
		return $stmt->execute();
    }

    //listagem amizades
	public function getFriends($queries = array()){
		$id = (array_key_exists("id", $queries)) ? $queries['id'] : ''; 
		$who_sent = (array_key_exists("who_sent", $queries)) ? $queries['who_sent'] : '';		
		$who_accepted = (array_key_exists("who_accepted", $queries)) ? $queries['who_accepted'] : '';		
		$status = array_key_exists("status", $queries) ? $queries['status'] : '';
		$dataativacao = array_key_exists("dataativacao", $queries) ? $queries['dataativacao'] : '';
		$excluido = array_key_exists("excluido", $queries) ? $queries['excluido'] : '';
		$order = array_key_exists("order", $queries) ? $queries['order'] : '';       
        
		$_where = array();
		if($id) array_push($_where, " id = :id ");
		if($who_sent) array_push($_where, " who_sent = :who_sent ");
		if($who_accepted) array_push($_where, " who_accepted = :who_accepted ");
		if($status) array_push($_where, " status = :status ");
		if($dataativacao) array_push($_where, " dataativacao = :dataativacao ");
		if($excluido) array_push($_where, " excluido = :excluido ");
		
		$w = '';
		if(count($_where) > 0){
			foreach($_where as $key=>$v){
				$w .= ' AND '.$v;
			}
		}

		$where = " WHERE excluido = 'nao'";
		$ordem = "ORDER BY id ASC";
		if($order) $ordem = $order;

		$sql  = "SELECT * FROM $this->table $where $w $ordem";

		$stmt = @BD::conn()->prepare($sql);

		if($id) $stmt->bindParam(':id', $id);
		if($who_sent) $stmt->bindParam(':who_sent', $who_sent);
		if($who_accepted) $stmt->bindParam(':who_accepted', $who_accepted);
		if($status) $stmt->bindParam(':status', $status);
		if($dataativacao) $stmt->bindParam(':dataativacao', $dataativacao);
		if($excluido) $stmt->bindParam(':excluido', $excluido);
        
		$stmt->execute();
		return $stmt->fetchAll();
	}
}
?>