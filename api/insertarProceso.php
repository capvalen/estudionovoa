<?php 
include('conectkarl.php');
$_POST = json_decode(file_get_contents('php://input'),true);

$primFecha = ( $_POST['fecha']==null ? date('Y-m-d') : $_POST['fecha'] );


$sql="INSERT INTO `proceso`(`id`, `idCliente`, `caso`, `antecedentes`, `tipopago`, `precio`, `cuotas`, `plazos`, `fecha`, `registrado`, `documento`, `activo`, `rutaDocumento`, `idUsuario`) VALUES 
(null, {$_POST['cliElegido']}, '{$_POST['caso']}', '{$_POST['antecedentes']}', {$_POST['floPagos']}, {$_POST['precio']}, {$_POST['numCuotas']}, '{$_POST['plazos']}', '{$primFecha}', now(), '".
 json_encode($_POST['documentos']) 
 ."', 1, '{$_POST['nombreRuta']}', {$_POST['idUsuario']});

";
//echo $sql;die();
$resultado=$cadena->query($sql);
if($resultado){
	$idProceso = $cadena->insert_id;

	if( count($_POST['fechas'])==0 ){
		$montoCuota = number_format($_POST['precio']/$_POST['numCuotas'],2);
	
		/* if($_POST['floPagos']=='1'){ //pago único
		} */
			$fecha = new DateTime($primFecha);
	
			switch ($_POST['plazos']){
				case "1": //DIARIO
					$intervalo = new DateInterval('P1D'); //aumenta 1 día
					break;
				case "2": //SEMANAL
					$intervalo = new DateInterval('P1W'); //aumenta 1 semana
					break;
				case "3": //Mensual
					$intervalo = new DateInterval('P30D'); //aumenta 15 días
					break;
				case "5": //Anual
					$intervalo = new DateInterval('P1Y'); //aumenta 30 día
					break;
				case null:
					$intervalo = new DateInterval('P0D'); //aumenta nada
				default: break;
			}
			/* if($_POST['plazos']=='2'){//pago en partes
			} */
			$cuotasAcum='';
			
			for ($i=1; $i <= $_POST['numCuotas'] ; $i++) { 
				$cuotasAcum= $cuotasAcum. "(null, {$idProceso}, '{$fecha->format('Y-m-d')}', {$montoCuota} )";
				if($i<$_POST['numCuotas']){ $cuotasAcum=$cuotasAcum.", "; }
				$fecha->add($intervalo);
			}
			
			$sqlCuotas="INSERT INTO `cuotas`(`id`, `idProceso`, `fecha`, `cuota` ) VALUES {$cuotasAcum}";
			$resultadoCuotas=$esclavo->query($sqlCuotas);
	}else{
		$fechas = $_POST['fechas'];
		for($i=0; $i< count($_POST['fechas']); $i++){
			$sqlCuotas="INSERT INTO `cuotas`(`id`, `idProceso`, `fecha`, `cuota` ) VALUES
				(null, {$idProceso}, '{$fechas[$i]['fecha']}', '{$fechas[$i]['monto']}' ) ";
			//echo $sqlCuotas;
			$resultadoCuotas=$esclavo->query($sqlCuotas);
		}
	}

	echo $idProceso;
}else{
	echo 'error';
}
?>