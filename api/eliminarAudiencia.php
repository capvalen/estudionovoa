<?php 
include('conectkarl.php');

$filas = array();

$sql="UPDATE `tipoaudiencia` SET `activo`=0 WHERE `id`= {$_POST['idAudiencia']}; ";
if($resultado=$cadena->query($sql)){
    echo 'ok';
}else{
    echo 'error';
}
?>