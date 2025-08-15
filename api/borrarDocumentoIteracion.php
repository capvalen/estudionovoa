<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);


$filas = array();

$sql="UPDATE `iteraciones` SET
`archivos` = ?
where `id` = {$_POST['id']};";
//echo $sql; die();
$sentencia = $db->prepare($sql);
if($resultado=$sentencia->execute( [ json_encode($_POST['documentos']) ] )){
    unlink("./../documentos/".$_POST['eliminar']);
    echo 1;    
}else{
    echo 0;
}

?>