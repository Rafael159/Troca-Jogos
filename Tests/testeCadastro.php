<?php
function __autoload($classe){
    require('../classes/'.$classe.'.class.php');
}
$user = new Usuarios();	

$cep = '08567-694';

$cep = $user::limpaCep($cep);
echo $cep;
$user->setNome('Teste');
$user->setEmail('teste@gmail.com');
$user->setSenha('125458');
$user->setCelular('114458-9568');
$user->setTelefone('1254587545');
$user->setConsole(2);
$user->setCEP($cep);
$user->setRua('teste');
$user->setNumero('10');
$user->setCidade('Suzano');
$user->setEstado('SP');
$user->setComplemento('sem saida');
$user->setStatus('sim');
$user->setTipoUsuario(1);
$user->setLogFirst(date('Y-m-d H:i'));
$user->setLogUsuario('');

if($user->insert()){
    echo 'Cadastrou';
}else{
    echo 'Falha';
}