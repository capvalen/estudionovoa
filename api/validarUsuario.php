<?php 

include 'conectkarl.php';
$_POST = json_decode(file_get_contents('php://input'),true);

$sql="SELECT * FROM `usuario`
where user = '{$_POST['userNick']}' and contrasena = md5('{$_POST['userPass']}') and activo =1;";
//echo $sql;
$resultado=$cadena->query($sql);
if($resultado->num_rows>=1){
	//echo 'ok';
	$row=$resultado->fetch_assoc();
	$datos =  array(
		'id' => intval($row['id']),
		'nombre' => "{$row['nombres']}, {$row['apellidos']} ",
		'tipo' => $row['idTipo']
	);
	echo json_encode($datos);
}else{
	echo 'error';
}




?>