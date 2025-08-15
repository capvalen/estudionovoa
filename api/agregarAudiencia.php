<?php

include('conectkarl.php');

$sql = $db->prepare("INSERT INTO `tipoaudiencia`(descripcion ) VALUES 
( ? ); ");
if($sql->execute([ $_POST['texto'] ])){
	echo $db->lastInsertId();
}else{
    echo -1;
}

?>