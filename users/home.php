<?php 
    function __autoload($classe){
	    require('../classes/'.$classe.'.class.php');
	}
	$idUser = Usuarios::getUsuario("id_user");
?>
<title>Dashboard</title>
<div class="row nopadding">
    <div class="content">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="card-stats">
                <div class="card-body">                    
                    <div class="card-title card-game">JOGOS ATIVOS</div>
                    <div class="row nopadding">
                        <div class="col-lg-5 card-category-icon">
                            <i class="fa fa-gamepad fa-3x"></i>
                        </div>
                        <div class="col-lg-7 card-category-numbers">
                            <div class="card-numbers card-numbers-game">
                                <?php 
                                    $gamesQnt = Jogos::contarJogosHelper(array("id_gamer"=>$idUser, "status"=>"Ativo"));
                                    echo (isset($gamesQnt)) ? $gamesQnt : "0";
                                ?>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="card-stats">
                <div class="card-body">
                    <div class="card-title-border">
                        <div class="card-title card-exchange">TROCAS</div>
                        <div class="row nopadding">
                            <div class="col-lg-5 card-category-icon">
                                <i class="fa fa-refresh fa-3x"></i>
                            </div>
                            <div class="col-lg-7 card-category-numbers">
                                <div class="card-numbers card-numbers-exchange">
                                    <?php
                                        $trocaQnt = Trocas::contaTrocasrHelper(array("idgamer"=>$idUser, "contar"=>"sim"));
                                        echo isset($trocaQnt) ? $trocaQnt : "0";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>