<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);


$filas = array();

$sql="UPDATE `iteraciones` SET
`archivos` = ". json_encode($_POST['documentos']) ."
where `id` = {$_POST['id']};";
//echo $sql;
if($resultado=$cadena->query($sql)){
    unlink("./../documentos/".$_POST['eliminar']);
    echo 1;    
}else{
    echo 0;
}

?>