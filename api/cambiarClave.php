<?php 
include('conectkarl.php');

$filas = array();

$sql="SELECT * FROM usuario where id = {$_POST['idUsuario']} and contrasena = md5('{$_POST['anterior']}'); ";
$resultado=$cadena->query($sql);
if($resultado->num_rows==1){
    $sqlActua = "UPDATE usuario set contrasena = md5('{$_POST['nueva']}') where id = {$_POST['idUsuario']};";
    //echo $sqlActua;
    if($respActua = $cadena->query($sqlActua)){
        echo 'ok';
    }else{
        echo 'error 1';
    }
}else{
    echo 'error 2';
}


?>