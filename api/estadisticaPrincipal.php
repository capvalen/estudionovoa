<?php 
include "conectkarl.php";

$sql="SELECT totalCasosActivosSistema() as totalCasos, totalCuotasAtrasadas() as totalCuotas, returnSumaCajaUltimoCuadre() as sumaCuadre, returnRestaCajaUltimoCuadre() as restaCuadre ";
$resultado=$cadena->query($sql);
$row=$resultado->fetch_assoc();
echo json_encode($row);
?>