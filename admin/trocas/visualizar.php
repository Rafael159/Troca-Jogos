<?php
	spl_autoload_register(function($classe) {
        require('../../classes/'.$classe.'.class.php');
    });
    $user  = new Usuarios;   
    $troca = new Trocas();
    $jogo  = new Jogos(); 

	//recebe o tipo de consulta
	$tipo = (isset($_POST['type']) ? $_POST['type'] : 'all');
	
	//$troca->setByUser((int)$userID);
        		
	switch ($tipo) {
		case 'all':
			$queries = array();
		break;
        case 'accepted':
			$queries = array('tipo'=>'Aceito');
        break;        
		case 'done':
            $queries = array('tipo'=>'Finalizada');			
		break;
		case 'received':
            $queries = array('tipo'=>'Pendente');
		break;
		case 'refused':
            $queries = array('tipo'=>'Recusado');
		break;
		case 'finished':
            $queries = array('tipo'=>'Finalizada');		
		break;
		default:
            $queries = array();        
		break;
    }
        
    $dados = Trocas::getTrocasHelper($queries);

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
            	<div class="col-lg-2">
            		<th class="top-title">VALOR RETORNO</th>
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
			    	
			    	foreach ($datagame as $marker => $rst):
			    		$mainjogo = $rst->n_jogo;
			    	endforeach;
        	?>	
            <tr class="line">
            	<div class="col-lg-1">
            		<th class="each-record">#<?php echo $rs->id?></th>
            	</div>
                <div class="col-lg-1">
            		<th class="each-record"><?php echo substr($rs->nomeUser, 0, 20)?></th>
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
            	<div class="col-lg-2">
            		<th class="each-record"><?php echo "R$ $rs->valor"?></th>
            	</div>
				<div class="col-lg-2">
            		<th class="each-record"><?php echo $rs->status; ?></th>
            	</div>
            	<div class="col-lg-2">
                    <td class="actions">                        
                        <div class="secao-btn">
							<span class="edge-btn"><a class="btn btn-warning btn-xs op_trocas" data-toggle="modal" onclick="viewTroca(<?php echo $rs->id?>)">Visualizar <i class="fa fa-eye" aria-hidden="true"></i></a></span>							
                        </div>                        
                    </td>
                </div>
            </tr>
            <?php endforeach;?>
        </tbody>
     </table>
 </div>
 <?php endif; ?>