<?php
	function __autoload($classe){
		require ('../../classes/'.$classe.'.class.php');
    }
    $jogos = new Jogos();
	// $console = new Consoles();
	// $imagem  = new Imagens();
?>
<title>Trocas</title>
<link rel="stylesheet" type="text/css" href="../css/fonts.css"/>

<div class="row nopadding">
	<div class="col-lg-12 nopadding">
		<div id="ctr_trocas">
            <header>
				<h3 class="title_page">Gerenciamento da trocas</h3>
			</header>
			<div class="col-lg-12">				
				<div class="btn-group">
					<button type="button" class="btn btn-default btn_exchange" id="all">Todas</button>
					<button type="button" class="btn btn-success btn_exchange" id="accepted">Aceitas</button>
					<button type="button" class="btn btn-warning btn_exchange" id="done">Feitas</button>
					<button type="button" class="btn btn-info btn_exchange" id="received">Recebidas</button>
					<button type="button" class="btn btn-danger btn_exchange" id="refused">Recusadas</button>
					<button type="button" class="btn btn-primary btn_exchange" id="finished">Finalizadas</button>
				</div>
            </div>
            <div class="col-lg-12">
				<div class="tr_container">
					<!-- // Recebe conteúdo das trocas-->
					<div id="list" class="row"></div><!--/#list -->
				</div><!--/.tr_container -->
			</div>   
            <!-- <div class="table-responsive col-lg-12 col-md-12">               
                <table class="table table-striped" id="tbl-trocas" cellspacing="0" cellpadding="0">
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
                            $rows = Trocas::getTrocasHelper(array());
                            
                            foreach($rows as $row => $rs):
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

                                $jogos->setID($takeID);//id do jogo do user 
                                $datagame = $jogos->listaJogoById();
                                
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
                                <th class="each-record"><?php echo $rs->game; ?></th>
                            </div>
                            <div class="col-lg-2">
                                <th class="each-record"><?php echo $type; ?></th>
                            </div>
                            <div class="col-lg-2">
                                <th class="each-record"><?php echo "R$ $rs->valor"?></th>
                            </div>
                            <div class="col-lg-2">
                                <th class="each-record"><?php echo $rs->status; ?></th>
                            </div>
                            <div class="col-lg-2">
                                <td class="actions">
                                    <?php  
                                        $owner = $rs->by_user;//pega o id de quem fez a troca
                                        $vlr = $rs->status;                            
                                    ?>
                                    <div class="secao-btn">
                                        <span class="edge-btn"><a class="btn btn-warning btn-xs op_trocas" data-toggle="modal" onclick="viewTroca(<?php echo $rs->id;?>)">Visualizar <i class="fa fa-eye" aria-hidden="true"></i></a></span>							
                                    </div>                        
                                </td>
                            </div>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div> -->
        </div>
    </div>
</div>
<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">	
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>		                
                <h4 class="modal-title">Informações da Troca</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="view_troca">
                    <!-- mostra os dados da troca -->								
                    </div><!-- /end #view_troca -->
                </div>
            </div>			            
        </div>
    </div>
</div>
<script src="../js/funcoes.js"></script>

<script>
    $(document).ready(function(){
        /* Função: buscar as trocas por status
        *  @param type - situação da troca (todas/aceitas/recusadas/etc)
        */
        function show_exchanges(type){            
            $.ajax({
                url : 'trocas/visualizar.php',
                type: 'post',
                data: 'type='+type,
                dataType: 'html'
            }).done(function(dados){
                if(dados == ''){
                    $('#list').html('<span class="error_msg">Nenhuma troca encontrada!</span>');
                }else{
                    $('#list').html(dados);                    
                }
            });
        }
        show_exchanges('all');/*primeiro load da página*/
        /*mudar tipo de trocas*/
        $('.btn_exchange').bind('click', function(){
            btn = $(this);//pegar botão clicado
            $('.btn_exchange').each(function(){
                if($(this).hasClass('btnActived')){
                    $(this).removeClass('btnActived');
                }
            });
            btn.addClass('btnActived');
            type = $(this).attr('id');/*tipo da consulta*/
            
            show_exchanges(type);/*chama função que mostra as trocas*/
        });
    });
</script>
