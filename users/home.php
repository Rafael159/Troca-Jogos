<?php 
    spl_autoload_register(function($classe) {
	    require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');
	});
	$idUser = Usuarios::getUsuario("id_user");
?>
<title>Dashboard</title>
<!-- <div class="row nopadding"> -->
<div class="content">
    <div class="row">
         <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="small-box" style="background:#069">
                <div class="inner">
                    <h3>
                        <?php 
                            $gamesQnt = Jogos::contarJogosHelper(array("id_gamer"=>$idUser, "status"=>"Ativo"));
                            echo (isset($gamesQnt)) ? $gamesQnt : "0";
                        ?>
                    </h3>
                    <p>Jogos Ativos</p>
                </div>
                <div class="icon">
                    <i class="fa fa-gamepad"></i>
                </div>
                <a href="jogos.php" class="small-box-footer button-link">
                    Ver mais <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="small-box" style="background:#0093b4">
                <div class="inner">
                    <h3>
                        <?php
                            $trocaQnt = Trocas::contaTrocasHelper(array("idgamer"=>$idUser, "contar"=>"sim"));
                            echo isset($trocaQnt) ? $trocaQnt : "0";
                        ?>
                    </h3>
                    <p>Trocas</p>
                </div>
                <div class="icon">
                    <i class="fa fa-refresh"></i>
                </div>
                <a href="trocas.php" class="small-box-footer button-link">
                    Ver mais <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    $(".button-link").on("click", function(event){
        event.preventDefault();
        var link = $(this).attr('href');
        
        reload(link);
     });
</script>