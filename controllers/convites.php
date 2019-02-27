<?php
function __autoload($classe){
    require('../classes/'.$classe.'.class.php');
}
@BD::conn();//conexão com o banco de dados	

$friend = new Friendships();

$idsend = ($_POST['idsend']) ? $_POST['idsend'] : '';
$idreceiver = ($_POST['idreceiver']) ? $_POST['idreceiver'] : '';

if(isset($idsend) AND isset($idreceiver)):
	$row = Friendships::getFriendsHelper(array('who_sent'=>$idsend, 'who_accepted'=>$idreceiver));
    if(count($row) == 0){
        $friend->setWhoSent($idsend);
        $friend->setWhoAccepted($idreceiver);
        $friend->setStatus("Pendente");
        $friend->setDataAtivacao(null);
        $friend->setExcluido("nao");

        if($friend->insert()){
            echo json_encode(array("status"=>"1"));
        }else{
            echo json_encode(array("status"=>"0"));
        }
    }else{
        echo json_encode(array("status"=>"1"));
    };
else:
    echo json_encode(array("status"=>"0"));
endif;

?>