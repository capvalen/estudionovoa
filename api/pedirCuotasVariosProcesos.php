<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);
$filas=[];

$linea = '';
$numeros =[];

//echo json_encode($_POST['procesos']);
for ($i=0; $i < count($_POST['procesos']) ; $i++) { 
	//$linea = $linea . $_POST['procesos'][$i]['id'];
	array_push($numeros, $_POST['procesos'][$i]['id'] );

	/* if($i<(count($_POST['procesos'])-1)){
		$linea=$linea."', '";
	} */

}

$parametros = implode(',', array_fill(0, count($numeros), '?'));

$sql = $db->prepare("SELECT * FROM `cuotas`
where idProceso in ( $parametros )
and activo = 1 and estado = 1; ");


if( $sql->execute( $numeros ) ){
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $row;
	}
}else{
	echo $sql->errorinfo();
}

//echo $sql->debugDumpParams();

echo json_encode($filas);