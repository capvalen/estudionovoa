<?php 

include('conectkarl.php');

$sql="UPDATE `agenda` SET activo =0 WHERE
id = '{$_POST['id']}';";
if($resultado=$cadena->query($sql)){
	echo 'ok';
}else{
	echo 'error';
}

/* var_dump($_POST); */
//print( json_encode($_POST));
?>