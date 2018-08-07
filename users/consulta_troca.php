<?php
	function __autoload($classe){
        require('..\classes/'.$classe.'.class.php');
    }
        
    $user  = new Usuarios();   
    $troca = new Trocas();
    $jogo  = new Jogos(); 
	session_start();
	$userID = (isset($_SESSION['id_user']) ? $_SESSION['id_user'] : '');

	//recebe o tipo de consulta
	$tipo = (isset($_POST['type']) ? $_POST['type'] : 'all');
	$troca->setByUser((int)$userID);
        		
	switch ($tipo) {
		case 'all':
			$dados = $troca->showAll();
		break;
        case 'acepted':
            $dados = $troca->showAccepted();
        break;        
		case 'done':
			$dados = $troca->showDone();
		break;
		case 'received':
			$dados = $troca->showReceived();
		break;
		case 'refused':
			$dados = $troca->showRefused();
		break;
		default:
			$dados = $troca->showAll();
		break;
	}
	if(empty($dados)):
		echo '';
	else:
?>
<div class="table-responsive col-lg-12 col-md-12">
    <table class="table table-striped" cellspacing="0" cellpadding="0" id="tbl-trocas">
        <thead>
            <tr class="line">
            	<div class="col-lg-1">
            		<th class="top-title">ID</th>
            	</div>
            	<div class="col-lg-1">
            		<th class="top-title">OFERTANTE</th>
            	</div>
            	<div class="col-lg-2">
            		<th class="top-title">JOGO OFERTA</th>
            	</div>
            	<div class="col-lg-2">
            		<th class="top-title">JOGO PRETENDIDO</th>
            	</div>
            	<div class="col-lg-2">
            		<th class="top-title">TIPO TROCA</th>
            	</div>
            	<div class="col-lg-2">
            		<th class="top-title">VALOR RETORNO</th>
            	</div>
            	<div class="col-lg-2">
            		<th class="top-title actions">AÇÕES</th>
            	</div>
             </tr>
        </thead>
        <tbody>
        	<?php
			    foreach ($dados as $key => $rs):                    
			    	$takeID = $rs->jogoum;//recebe o id do jogo pretendido

			    	switch ($rs->tipo) {
			    		case 0:
			    			$type = 'Meu jogo vale mais';
			    			break;
			    		case 1:
			    			$type = 'Equilibrado';
			    			break;
			    		default:
			    			$type = 'Meu jogo vale menos';
			    			break;
			    	}

			    	$jogo->setID($takeID);//id do jogo do user 
			    	$datagame = $jogo->listaJogoById();
			    	
			    	foreach ($datagame as $marker => $rst):
			    		$mainjogo = $rst->n_jogo;
			    	endforeach;
        	?>	
            <tr class="line">
            	<div class="col-lg-1">
            		<th class="each-record">#<?php echo $rs->id_troca?></th>
            	</div>
                <div class="col-lg-1">
            		<th class="each-record"><?php echo substr($rs->nomeUser, 0, 20)?></th>
            	</div>
            	<div class="col-lg-2">
            		<th class="each-record"><?php echo $mainjogo?></th>
            	</div>
            	<div class="col-lg-2">
            		<th class="each-record"><?php echo $rs->game?></th>
            	</div>
            	<div class="col-lg-2">
            		<th class="each-record"><?php echo $type?></th>
            	</div>
            	<div class="col-lg-2">
            		<th class="each-record"><?php echo "R$ $rs->valor"?></th>
            	</div>
            	<div class="col-lg-2">
                    <td class="actions">
                        <?php  
                            $owner = $rs->by_user;//pega o id de quem fez a troca
                            $vlr = $rs->status;
                            if($vlr==0 && ($owner != $userID) && ($tipo=='received' || $tipo=='all')){
                        ?>
                        <a class="btn btn-success btn-xs" onclick="update(<?php echo $rs->id_troca?>, 1)">Aceitar</a>
                        <a class="btn btn-danger btn-xs" onclick="update(<?php echo $rs->id_troca?>, 2)">Recusar</a>
                        <?php } ?>
                        <div class="secao-btn">
                            <a class="btn btn-warning btn-xs op_trocas" data-toggle="modal" onclick="viewTroca(<?php echo $rs->id_troca?>)">Visualizar</a>
                            <a class="btn btn-danger btn-xs op_delete" onclick='deleteTroca(this)'>Excluir</a>
                        </div>
                        <div class="confirm-box">
                            <div class="confirm-header">Tem certeza que deseja excluir a troca?</div>
                            <div class="confirm-content">
                                <div class="btn-group">
                                    <button class="btn btn-success btn-md" onclick='confirmDelete(<?php echo $rs->id_troca?>)'>Sim</button>
                                    <button class="btn btn-danger btn-md btnCancel" onclick='cancelDelete(this)'>Não</button>
                                </div>
                            </div>
                        </div>                        
                    </td>
                </div>
            </tr>
            <?php endforeach;?>
        </tbody>
     </table>
 </div>
 <?php endif; ?>