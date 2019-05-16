<?php

spl_autoload_register(function($classe) {
    require(dirname(dirname(__FILE__)).'/classes/'.$classe.'.class.php');
});

    $consoles = new Consoles();
    $dados = array();

    $grupoConsoles = $consoles->showAll($dados);
?>
    <option value="">Selecione...</option>
<?php    
    foreach($grupoConsoles as $k=> $console): ?>
        <option value="<?php echo $console->id_console ?>"><?php echo $console->nome_console ?></option>
    <?php
        endforeach;
    ?>