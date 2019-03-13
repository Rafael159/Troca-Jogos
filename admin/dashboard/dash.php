<?php 
    function __autoload($classe){
	    require('../../classes/'.$classe.'.class.php');
    }
?>
<title>Dashboard</title>
<div class="row nopadding">
    <div class="content">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="card-stats">
                <div class="card-body">                    
                    <div class="card-title card-users">USUÁRIOS</div>
                    <div class="row nopadding">
                        <div class="col-lg-5 card-category-icon">
                            <i class="fa fa-user fa-3x"></i>
                        </div>
                        <div class="col-lg-7 card-category-numbers">
                            <div class="card-numbers card-numbers-users">
                                <?php 
                                    $userQnt = Usuarios::getRegisterHelper(array("contar"=>"sim", "tipousuario"=>"0", "status"=>"sim"));
                                    echo (isset($userQnt)) ? $userQnt : '0';
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
                    <div class="card-title card-game">JOGOS ATIVOS</div>
                    <div class="row nopadding">
                        <div class="col-lg-5 card-category-icon">
                            <i class="fa fa-gamepad fa-3x"></i>
                        </div>
                        <div class="col-lg-7 card-category-numbers">
                            <div class="card-numbers card-numbers-game">
                                <?php 
                                    $gamesQnt = Jogos::contarJogosHelper(array("status"=>"Ativo"));
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
                                        $trocaQnt = Trocas::contaTrocasrHelper(array("contar"=>"sim"));
                                        echo isset($trocaQnt) ? $trocaQnt : "0";
                                    ?>
                                </div>
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
                        <div class="card-title card-images">IMAGENS</div>
                        <div class="row nopadding">
                            <div class="col-lg-5 card-category-icon">
                                <i class="fa fa-picture-o fa-3x"></i>
                            </div>
                            <div class="col-lg-7 card-category-numbers">
                                <div class="card-numbers card-numbers-images">
                                    <?php
                                        $imagemQnt = Imagens::contaImagesHelper(array("contar"=>"sim"));
                                        echo isset($imagemQnt) ? $imagemQnt : "0";
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