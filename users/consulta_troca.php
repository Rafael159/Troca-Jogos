<?php
	spl_autoload_register(function($classe) {
        require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');
    });
        
    $user  = new Usuarios();   
    $troca = new Trocas();
    $jogo  = new Jogos(); 
	
	$userID = Usuarios::getUsuario('id_user');

	//recebe o tipo de consulta
	$tipo = (isset($_POST['type']) ? $_POST['type'] : 'all');
	
	$troca->setByUser((int)$userID);
        		
	switch ($tipo) {
		case 'all':
			$dados = $troca->showAll();
		break;
        case 'accepted':
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
		case 'finished':
			//$dados = $troca->showFinished();
			$dados = $troca->getTrocas(array('tipo'=>'Finalizada', 'idgamer'=>$userID));
		break;
		default:
			$dados = $troca->showAll();
		break;
	}
	if(empty($dados)):		
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
            	<div class="col-lg-1">
            		<th class="top-title">RETORNO</th>
            	</div>
				<div class="col-lg-2">
            		<th class="top-title">STATUS</th>
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
					$owner = $rs->by_user;//pega o id de quem fez a troca
				
			    	foreach ($datagame as $marker => $rst):
			    		$mainjogo = $rst->n_jogo;
			    	endforeach;
        	?>	
            <tr class="line">
            	<div class="col-lg-1">
            		<th class="each-record">#<?php echo $rs->id?></th>
            	</div>
                <div class="col-lg-1">
            		<th class="each-record">
						<?php if($owner != $userID): ?>
							<a href="../feed.php?codigo=<?php echo $owner?>">							
							<i class="fa fa-comments" aria-hidden="true"></i>
						<?php endif; ?>
							<?php echo substr($rs->nomeUser, 0, 20)?>
							<?php if($owner != $userID): ?>
						</a>						
							<?php endif; ?>
					</th>
            	</div>
            	<div class="col-lg-2">
            		<th class="each-record"><?php echo (isset($mainjogo)) ? $mainjogo : ''; ?></th>
            	</div>
            	<div class="col-lg-2">
            		<th class="each-record"><?php echo $rs->game?></th>
            	</div>
            	<div class="col-lg-2">
            		<th class="each-record"><?php echo $type?></th>
            	</div>
            	<div class="col-lg-1">
            		<th class="each-record"><?php echo "R$ $rs->valor"?></th>
            	</div>
				<div class="col-lg-2">
            		<th class="each-record"><?php echo $rs->status; ?></th>
				</div>				
            	<div class="col-lg-2">
                    <td class="actions">
                        <?php
                            $vlr = $rs->status;
                            if($vlr=="Pendente" && ($owner != $userID) && ($tipo=='received' || $tipo=='all')):
                        ?>
                        <span class="edge-btn"><a class="btn btn-success btn-xs" onclick="update(<?php echo $rs->id?>, 'Aceito')" >Aceitar <i class="fa fa-handshake-o" aria-hidden="true"></i></a></span>
                        <span class="edge-btn"><a class="btn btn-danger btn-xs" onclick="update(<?php echo $rs->id?>, 'Recusado')">Recusar <i class="fa fa-remove" aria-hidden="true"></i></a></span>
						<?php endif; ?>
						<?php if($vlr=="Aceito" AND $owner==$userID): ?><span class="edge-btn"><a class="btn btn-success btn-xs" onclick="finalizarTroca(<?php echo $rs->id?>)">Finalizar Troca <i class="fa fa-check" aria-hidden="true"></i></a></span><?php endif; ?>
                        <div class="secao-btn">
							<span class="edge-btn"><a class="btn btn-warning btn-xs op_trocas" data-toggle="modal" onclick="viewTroca(<?php echo $rs->id?>)">Visualizar <i class="fa fa-eye" aria-hidden="true"></i></a></span>
							<?php if($vlr == "Pendente" AND $owner==$userID): ?>
								<span class="edge-btn"><a class="btn btn-danger btn-xs op_delete" onclick='deleteTroca(this)'>Excluir <i class="fa fa-remove" aria-hidden="true"></i></a></span>
								<div class="confirm-box">
									<div class="confirm-header">Tem certeza que deseja excluir a troca?</div>
									<div class="confirm-content">
										<div class="btn-group">
											<button class="btn btn-danger btn-md btnCancel" onclick='cancelDelete(this)'>Não <i class="fa fa-remove" aria-hidden="true"></i></button>
											<button class="btn btn-success btn-md" onclick='confirmDelete(<?php echo $rs->id?>)'>Sim <i class="fa fa-check" aria-hidden="true"></i></button>
										</div>
									</div>
								</div>
							<?php endif; ?>
                        </div>                        
                    </td>
				</div>				
            </tr>
            <?php endforeach;?>
        </tbody>
     </table>
 </div>
 <?php endif; ?>