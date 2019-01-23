<?php

	class Trocas extends Crud
	{
		protected $table = 'trocas';

		private $id;
		private $idUserUm;
		private $idUserDois;
	    private $jogoUm;
	    private $jogoDois;
	    private $valor;
	    private $tipoTroca;
	    private $mensagem;
	    private $status;
	    private $by_user;/*recebe o id de quem faz o pedido de troca*/

	    //SETS
	    public function setId($id){
	    	$this->id = $id;
	    }
	    public function setIdUserUm($idUserUm){
	    	$this->idUserUm = $idUserUm;
	    }
	    public function setIdUserDois($idUserDois){
	    	$this->idUserDois = $idUserDois;
	    }
		public function setJogoUm($jogoUm){
			$this->jogoUm = $jogoUm;
		}
		public function setJogoDois($jogoDois){
			$this->jogoDois = $jogoDois;
		}		
		public function setTipoTroca($tipoTroca){
			$this->troca = $tipoTroca;
		}
		public function setValor($valor){
			$this->valor = $valor;
		}
		public function setMensagem($mensagem){
			$this->mensagem = $mensagem;
		}
		public function setStatus($status){
			$this->status = $status;
		}
		public function setByUser($by_user){
			$this->by_user = $by_user;
		}
		public function setlogCriacao($logcriacao){
			$this->logcriacao = $logcriacao;
		}
		public function setlogData($logdata){
			$this->logdata = $logdata;
		}

		public function insert(){
			$sql = "INSERT INTO $this->table (idUm, idDois, jogoum, jogodois, valor, tipo, mensagem, status, by_user, logdata, logcriacao) VALUES (
					:idUm, :idDois, :jogoum, :jogodois, :valor, :tipo, :mensagem, :status, :by_user, :logdata, :logcriacao)";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':idUm', $this->idUserUm);
			$stmt->bindParam(':idDois', $this->idUserDois);
			$stmt->bindParam(':jogoum', $this->jogoUm);
			$stmt->bindParam(':jogodois',$this->jogoDois);
			$stmt->bindParam(':valor',$this->valor);
			$stmt->bindParam(':tipo',$this->troca);
			$stmt->bindParam(':mensagem',$this->mensagem);
			$stmt->bindParam(':status',$this->status);
			$stmt->bindParam(':by_user',$this->by_user);
			$stmt->bindParam(':logdata',$this->logdata);
			$stmt->bindParam(':logcriacao', $this->logcriacao);
			
			return $stmt->execute();
		}
		/*Funcão: excluir a troca
		* @id - receberá o ID da troca
		* @return - boolean
		*/
		public function deleteTroca(){

			$sql = "DELETE FROM $this->table WHERE id = :id";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':id', $this->id);

			return $stmt->execute();

		}

		/*
		* não terá update de trocas no momento// feito aqui por causa da classe Crud
		*/
		public function update(){}
		
		public function getTrocas($queries = array()){
			$id = array_key_exists("id", $queries) ? $queries['id'] : '';
			$status = array_key_exists("tipo", $queries) ? $queries['tipo'] : '';
			$idgamer = array_key_exists("idgamer", $queries) ? $queries['idgamer'] : '';
			$_where = array();
			
			if($id) array_push($_where, "tc.id = $id");
			if($idgamer) array_push($_where, "(tc.idUm = $idgamer || tc.idDois = $idgamer)");
			if($status) array_push($_where, "tc.status = '$status'");

			$w = '';
			if(sizeof($_where) > 0){
				foreach($_where as $key=>$v){
					$w .= ' AND '.$v;
				}
			}

			$sql = "SELECT tc.id AS 'id_troca', tc.idUm, tc.idDois, tc.tipo, tc.valor, tc.by_user, j.n_jogo AS 'game', tc.jogoum, tc.jogodois, tc.status, u.nomeUser
					FROM  `trocas` AS tc, (((`jogos` AS j
					INNER JOIN  `console` AS c ON j.id_console = c.id_console)
					INNER JOIN  `imagens` AS i ON j.img_jogo = i.id_img)
					INNER JOIN  `usuarios` AS u ON j.id_gamer = u.id_user)
					WHERE tc.status is not null					
					$w
					GROUP BY tc.id
					ORDER BY tc.id DESC";
			
			$stmt = @BD::conn()->prepare($sql);
			echo '<pre>';
			print_r($stmt);
			// $stmt->bindParam(':by_user', $this->by_user);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		/*
		 * Função: Mostrar todas as trocas relacionada ao usuário
		 * @return lista com registros das trocas
		 */
		public function showAll($queries = array()){			

			$sql = "SELECT tc.id AS 'id_troca', tc.idUm, tc.idDois, tc.tipo, tc.valor, tc.by_user, j.n_jogo AS 'game', tc.jogoum, tc.jogodois, tc.status, u.nomeUser
					FROM  `trocas` AS tc, (((`jogos` AS j
					INNER JOIN  `console` AS c ON j.id_console = c.id_console)
					INNER JOIN  `imagens` AS i ON j.img_jogo = i.id_img)
					INNER JOIN  `usuarios` AS u ON j.id_gamer = u.id_user)
					WHERE (tc.idUm = :by_user OR tc.idDois = :by_user) AND (tc.jogodois = j.id)					
					GROUP BY tc.id
					ORDER BY tc.id DESC";
			
			$stmt = @BD::conn()->prepare($sql);
			// echo '<pre>';
			// print_r($stmt);
			$stmt->bindParam(':by_user', $this->by_user);
			$stmt->execute();
			return $stmt->fetchAll();

		}
		/*
		 * Função: Mostrar todas as trocas feitas pelo user 
		 * @return lista com registros das trocas
		 */
		public function showDone(){

			$sql = "SELECT tc.id AS 'id_troca', tc.idUm, tc.idDois, tc.tipo, tc.valor, tc.by_user, j.n_jogo AS 'game', tc.jogoum, tc.jogodois, tc.status, u.nomeUser
					FROM  `trocas` AS tc, (((`jogos` AS j
					INNER JOIN  `console` AS c ON j.id_console = c.id_console)
					INNER JOIN  `imagens` AS i ON j.img_jogo = i.id_img)
					INNER JOIN  `usuarios` AS u ON j.id_gamer = u.id_user)
					WHERE (tc.by_user = :by_user) AND (tc.jogodois = j.id)
					AND tc.status != 2
					GROUP BY tc.id
					ORDER BY tc.id DESC";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':by_user', $this->by_user);
			$stmt->execute();
			return $stmt->fetchAll();

		}

		/*
		 * Função: Mostrar todas as trocas recebidas
		 * @return lista com registros das trocas
		 */
		public function showReceived(){

			$sql = "SELECT tc.id AS 'id_troca', tc.idUm, tc.idDois, tc.tipo, tc.valor,tc.by_user, j.n_jogo AS 'game', tc.jogoum, tc.jogodois, tc.status, u.nomeUser
					FROM  `trocas` AS tc, (((`jogos` AS j
					INNER JOIN  `console` AS c ON j.id_console = c.id_console)
					INNER JOIN  `imagens` AS i ON j.img_jogo = i.id_img)
					INNER JOIN  `usuarios` AS u ON j.id_gamer = u.id_user)
					WHERE (tc.idUm = :by_user) AND (tc.jogodois = j.id)
					AND tc.status != 2 
					GROUP BY tc.id
					ORDER BY tc.id DESC";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':by_user', $this->by_user);
			$stmt->execute();
			return $stmt->fetchAll();

		}
		/*
		 * Função: Mostrar todas as trocas recebidas
		 * @return lista com registros das trocas
		 */
		public function showRefused(){

			$sql = "SELECT tc.id AS 'id_troca', tc.idUm, tc.idDois, tc.tipo, tc.valor, tc.by_user, j.n_jogo AS 'game', tc.jogoum, tc.jogodois, tc.status, u.nomeUser
					FROM  `trocas` AS tc, (((`jogos` AS j
					INNER JOIN  `console` AS c ON j.id_console = c.id_console)
					INNER JOIN  `imagens` AS i ON j.img_jogo = i.id_img)
					INNER JOIN  `usuarios` AS u ON j.id_gamer = u.id_user)
					WHERE (tc.idUm = :by_user OR tc.idDois = :by_user) AND (tc.jogodois = j.id)
					AND tc.status = 'Recusado' 
					GROUP BY tc.id
					ORDER BY tc.id DESC";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':by_user', $this->by_user);
			$stmt->execute();
			return $stmt->fetchAll();

		}
		public function showAccepted(){

			$sql = "SELECT tc.id AS 'id_troca', tc.idUm, tc.idDois, tc.tipo, tc.valor, tc.by_user, j.n_jogo AS 'game', tc.jogoum, tc.jogodois, tc.status, u.nomeUser
					FROM  `trocas` AS tc, (((`jogos` AS j
					INNER JOIN  `console` AS c ON j.id_console = c.id_console)
					INNER JOIN  `imagens` AS i ON j.img_jogo = i.id_img)
					INNER JOIN  `usuarios` AS u ON j.id_gamer = u.id_user)
					WHERE (tc.by_user != :by_user) AND (tc.jogodois = j.id)
					AND tc.status = 'Aceito' 
					GROUP BY tc.id
					ORDER BY tc.id DESC";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':by_user', $this->by_user);
			$stmt->execute();
			return $stmt->fetchAll();
		}

		/*
		 * Função: Show the informations of a changing passing the ID as parameter
		 * @return return the object containing the informations
		 */
		public function showByID(){

			$sql = "SELECT tc.id, tc.idUm, tc.idDois , tc.tipo, tc.valor, tc.by_user, 
						   tc.jogoum, tc.jogodois, tc.status AS `estado_atual`, tc.mensagem, u.nomeUser, j.n_jogo, i.imagem, c.nome_console
					FROM  `trocas` AS tc, (((`jogos` AS j
					INNER JOIN  `console` AS c ON j.id_console = c.id_console)
					INNER JOIN  `imagens` AS i ON j.img_jogo = i.id_img)
					INNER JOIN  `usuarios` AS u ON j.id_gamer = u.id_user)
					WHERE tc.id = :id AND tc.jogoum = j.id
					GROUP BY tc.id";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':id', $this->id);
			$stmt->execute();
			return $stmt->fetchAll();
		}
		/*
		 * Função: Mudar o status da troca pelo ID
		 * @return lista com registros das trocas
		 */
		public function changeStatus(){

			$sql = "UPDATE $this->table SET status = :status, logdata = :logdata WHERE id = :id";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':status', $this->status);
			$stmt->bindParam(':logdata', $this->logdata);
			$stmt->bindParam(':id', $this->id);
			return $stmt->execute();

		}

		//contar quantas trocas ativas o usuário possui, passando o ID como parâmetro
		public function contaTrocaById(){

			$sql = "SELECT * FROM $this->table WHERE (idUm = :cod OR idDois = :cod) AND (status = 0 OR status = 1)";
			$stmt = @BD::conn()->prepare($sql);
			$stmt->bindParam(':cod', $this->by_user);
			$stmt->execute();
			return $stmt->rowCount();	
			
		}
	}
?>