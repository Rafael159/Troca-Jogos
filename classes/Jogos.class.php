<?php

class Jogos extends Crud{
	
	protected $table = 'jogos';

	private $id;
	private $nome;
	private $imagem;
	private $idCons;
	private $idGamer;
	private $jogoTroca;
	private $data;
	private $descricao;

	public function setID($id){
		$this->id = $id;
	}
	public function setNome($nome){
		$this->nome = $nome;
	} 
	public function setImagem($imagem){
		$this->imagem = $imagem;
	}
	public function setIdCons($idCons){
		$this->idCons = $idCons;
	}
	public function setIdGamer($idGamer){
		$this->idGamer = $idGamer;
	}
	public function setJogoT($jogoTroca){
		$this->jogoTroca = $jogoTroca;
	}
	public function setIdJogoT($idJogoTroca){
		$this->idJogoTroca = $idJogoTroca;
	}
	public function setData($data){
		$this->data = $data;
	}
	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	public function setInfoExtra($infoExtra){
		$this->infoExtra = $infoExtra;
	}
	public function setStatus($status){
		$this->status = $status;
	}

	//inserir jogos no banco de dados
	public function insert(){
		$sql = "INSERT INTO $this->table (n_jogo, img_jogo, id_console, id_gamer, jogoTroca, idJogoTroca, data, descricao, informacao) VALUES (
				:nome, :imagem, :idCons, :idGamer, :jogoTroca, :idJogoTroca, :data, :descricao, :infoExtra)";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':nome', $this->nome);
		$stmt->bindParam(':imagem',$this->imagem);
		$stmt->bindParam(':idCons',$this->idCons);
		$stmt->bindParam(':idGamer',$this->idGamer);
		$stmt->bindParam(':jogoTroca',$this->jogoTroca);
		$stmt->bindParam(':idJogoTroca',$this->idJogoTroca);
		$stmt->bindParam(':data',$this->data);
		$stmt->bindParam(':descricao',$this->descricao);
		$stmt->bindParam(':infoExtra',$this->infoExtra);
		
		$stmt->execute();
		return @BD::conn()->lastInsertId();//retorno o ID do jogo que foi inserido
		
	}
	/*
	 *Atualizar IMAGEM E CONSOLE não funcionam no momento. Arrumar futuramente
	*/
	public function update(){
		$sql = "UPDATE $this->table SET n_jogo = :nome, img_jogo = :imagem, id_gamer = :idGamer,
		 								 jogoTroca = :jogoTroca, descricao = :descricao, informacao = :infoExtra WHERE id = :id";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':nome', $this->nome);
		$stmt->bindParam(':imagem',$this->imagem);
		//$stmt->bindParam(':idCons',$this->idCons);
		$stmt->bindParam(':idGamer',$this->idGamer);
		$stmt->bindParam(':jogoTroca',$this->jogoTroca);
		//$stmt->bindParam(':data',$this->data);
		$stmt->bindParam(':descricao',$this->descricao);
		$stmt->bindParam(':infoExtra',$this->infoExtra);
		$stmt->bindParam(':id', $this->id);
					
		return $stmt->execute();		
	}

	/*
		 * Função: Mudar o status do jogo pelo ID
		 * @return jogo
		 */
		public function changeStatus($id, $status){

			$sql = "UPDATE $this->table SET status = :status WHERE id = :id";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':status', $status);		
			$stmt->bindParam(':id', $id);
			return $stmt->execute();

		}

	/*
	 * Função: Deletar jogo
	*/
	public function delete(){

		$sql  = "DELETE FROM $this->table WHERE (id = :id_jogo)";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id_jogo', $this->id);			
		$stmt->execute();

		return $stmt;
	}

	/*listar jogos de acordo com a pesquisa feita*/
	public function listarJogos($queries = array()){

		$jogo = array_key_exists("jogo", $queries) ? $queries['jogo'] : '';
		$id = array_key_exists("id", $queries) ? $queries['id'] : '';
		$console = array_key_exists("console", $queries) ? $queries['console'] : '';
		$idconsole = array_key_exists("idconsole", $queries) ? $queries['idconsole'] : '';
		$order = array_key_exists("order", $queries) ? $queries['order'] : '';
		$id_gamer = array_key_exists("id_gamer", $queries) ? $queries['id_gamer'] : '';
		$status = array_key_exists("status", $queries) ? $queries['status'] : '';
		$limite = array_key_exists("limite", $queries) ? $queries['limite'] : '';

		$_where = array();
		if($jogo) array_push($_where, " UPPER(j.n_jogo) LIKE UPPER('%".$jogo."%')");
		if($id) array_push($_where, " id = $id");
		if($console) array_push($_where, " nome_console = '$console'");
		if($idconsole) array_push($_where, " j.id_console = '$idconsole'");
		if($id_gamer) array_push($_where, " id_gamer = '$id_gamer'");		
		if($status) {
			if($status == 'Ambos') array_push($_where, " (j.status = 'Ativo' OR j.status = 'Inativo')"); 
			if($status != 'Ambos') array_push($_where, " j.status = '$status'");
		}

		$w = '';
		if(sizeof($_where) > 0){
			foreach($_where as $key=>$v){
				$w .= ' AND '.$v;
			}
		}
		$limit = ($limite) ? "LIMIT $limite" : ""; 

		$ordem = "ORDER BY j.id ASC";
		if($order) $ordem = $order;

		$sql = "SELECT j.id, j.n_jogo, j.img_jogo, j.id_console, j.id_gamer, j.jogoTroca, j.idJogoTroca, j.data,
				j.descricao, j.informacao, j.status, c.nome_console, i.id_img, i.nome, i.imagem, u.id_user,
				u.nomeUser, u.celular, u.telefone, u.rua, u.numero, u.cidade, u.estado, u.complemento, u.console
				FROM ((($this->table as j INNER JOIN `console` as c ON j.id_console = c.id_console)
				INNER JOIN `imagens` as i ON j.img_jogo = i.id_img)
				INNER JOIN `usuarios` as u ON  u.id_user = j.id_gamer)
				WHERE j.img_jogo is not null $w $ordem $limit";
		
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindValue(':busca', '%'.$this->nome.'%');
		$stmt->execute();
		$resultado = $stmt->fetchAll();
		
		return $resultado;
	}/*Final listar Jogo*/

	//contar quantos jogos o usuário possui, passando o ID como parâmetro
	public function contaJogoById(){

		$sql = "SELECT COUNT(*) as total FROM $this->table WHERE id_gamer = :cod";
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':cod', $this->idGamer);
		$stmt->execute();
		$row = $stmt->fetchAll();
		$total = $row['0']->total;

		if($total < 0) return false;
		return $total;
		
	}

	public function contarJogos($queries = array()){		
		$status = array_key_exists('status', $queries) ? $queries['status'] : '';
		$idconsole = array_key_exists('idconsole', $queries) ? $queries['idconsole'] : '';
		$id_gamer = array_key_exists('id_gamer', $queries) ? $queries['id_gamer'] : '';		
		
		$_where = array();
		if($status) {
			if($status == 'Ambos') array_push($_where, " (status = 'Ativo' OR status = 'Inativo')"); 
			if($status != 'Ambos') array_push($_where, " status = '$status'");
		}
		
		if($idconsole) array_push($_where, " id_console = $idconsole");
		if($id_gamer) array_push($_where, " id_gamer = $id_gamer");

		$w = '';
		if(sizeof($_where) > 0){
			foreach($_where as $key=>$v){
				$w .= ' AND '.$v;
			}
		}

		$sql = "SELECT * FROM $this->table WHERE id_gamer is not null $w";

		$stmt = @BD::conn()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();

	}
	public static function contarJogosHelper($queries = array()){		
		$rows = new Jogos;
		$row = $rows->listarJogos($queries);
				
		if(count($row) == 0) return false;
		return count($row);
	}
	public function listaJogoByUser($status = 'Ativo'){
		
		$sql = "SELECT * FROM `console` as c, `imagens` as i, `usuarios` as u, `jogos` as j
					    WHERE j.id_gamer = u.id_user
					    AND j.id_console = c.id_console
					    AND j.img_jogo = i.id_img
					    AND u.id_user = :codigo
						AND j.status = :status
					    ORDER BY j.id";
		
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':status', $status);
		$stmt->bindParam(':codigo', $this->idGamer);
		$stmt->execute();
		return $stmt->fetchAll();
		
	}

	public function listaJogoByUserDesc($cod, $status){
		
		$sql = "SELECT * FROM `console` as c, `imagens` as i, `usuarios` as u, `jogos` as j
					    WHERE j.id_gamer = u.id_user
					    AND j.id_console = c.id_console
					    AND j.img_jogo = i.id_img
					    AND u.id_user = :codigo
					    AND j.status = :status
					    ORDER BY j.id DESC";
		
		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':codigo', $cod);
		$stmt->bindParam(':status', $status);
		$stmt->execute();
		return $stmt->fetchAll();
		
	}
	/*
	 * Seleciona o jogo pelo ID
	 * @param $id - ID do jogo
	 * return JOGO
	*/
	public function listaJogoById(){
		$sql = "SELECT j.id, j.n_jogo, j.img_jogo, j.id_console, j.id_gamer, j.jogoTroca, j.idJogoTroca, j.data,
				j.descricao, j.informacao, j.status, c.nome_console, i.id_img, i.nome, i.imagem, u.id_user,
				u.nomeUser, u.celular, u.telefone, u.rua, u.numero, u.cidade, u.estado, u.complemento, u.console
				FROM ((($this->table as j INNER JOIN `console` as c ON j.id_console = c.id_console)
				INNER JOIN `imagens` as i ON j.img_jogo = i.id_img)
				INNER JOIN `usuarios` as u ON  u.id_user = j.id_gamer)
				WHERE j.id = :id";

		$stmt = @BD::conn()->prepare($sql);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public function listaTodosJogos($queries = array()){

		$sql = "SELECT * FROM ((((`jogos` as j INNER JOIN `console` as c ON j.id_console = c.id_console) 
			    INNER JOIN `imagens` as i ON j.img_jogo = i.id_img) 
				INNER JOIN `jogocategoria` as jc ON j.id = jc.jogo_id)
				INNER JOIN `usuarios` as u ON j.id_gamer = u.id_user)
				GROUP BY jc.jogo_id ORDER BY j.id ";

		$stmt = @BD::conn()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}
