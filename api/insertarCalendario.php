<?php 

include('conectkarl.php');

$sql="INSERT INTO `agenda`(`id`, `asunto`, `descripcion`, `comienza`, `termina`, `inicia`, color, idAbogado, idTipoAudiencia, expediente ) VALUES 
(null, '{$_POST['asunto']}', '{$_POST['detalles']}', '{$_POST['comienza']}', '{$_POST['termina']}', cast('{$_POST['comienza']}' as Date), '{$_POST['color']}', {$_POST['abogado']}, {$_POST['idTipoAudiencia']}, '{$_POST['expediente']}' );";
if($resultado=$cadena->query($sql)){
	echo $cadena->insert_id;
}else{
	echo 'error';
}

/* var_dump($_POST); */
//print( json_encode($_POST));
?>