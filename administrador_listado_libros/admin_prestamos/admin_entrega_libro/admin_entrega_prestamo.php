<?php
require_once('../../../conexion_querys/conexion.php');

$proc = new proceso();
$conn = $proc->conn();
mysqli_set_charset($conn,"utf8mb4");


$id_libro = mysqli_real_escape_string($conn, $_POST['id_libro']);
$cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
$id_prestamo = mysqli_real_escape_string($conn, $_POST['id_prestamo']);
$sql = "SELECT * FROM prestamos WHERE id_libro = $id_libro";
$result = $proc->ejecutar_qury($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);

$fecha_entrega = strtotime(date("d-m-Y H:i:00",time()));
$fecha_entrada = strtotime($row['fecha_max_devolucion']);
	
if($fecha_entrega < $fecha_entrada || $fecha_actual > $fecha_entrega){
    $sql = "UPDATE usuarios SET puntaje = (SELECT puntaje)-1 WHERE cedula = ".$row['cc_usuario'];
    $proc->ejecutar_qury($conn, $sql);
    echo '<script>alert("La fecha de entrega excedio la fecha maxima permitida, se penalizara al usuario.");</script>';
}else{
    echo '<script>alert("El libro ha sido entregado con exito.");</script>';
}

$sql = "UPDATE prestamos
SET estado_prestamo = 'ENTREGADO', fecha_entrega = NOW() 
WHERE id_prestamo = $id_prestamo;";
$proc->ejecutar_qury($conn, $sql);
$proc->volver_listado_prestamo($cc_usuario_sesion, $id_libro);
?>