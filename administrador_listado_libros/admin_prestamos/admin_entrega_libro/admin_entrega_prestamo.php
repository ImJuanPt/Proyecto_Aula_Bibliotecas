<?php
require_once('../../../conexion_querys/conexion.php');

$proc = new proceso();
$conn = $proc->conn();
mysqli_set_charset($conn,"utf8mb4");

$id_libro = mysqli_real_escape_string($conn, $_POST['id_libro']);

$sql = "SELECT * FROM prestamos WHERE id_libro = $id_libro";
$result = $proc->ejecutar_qury($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);

$fecha_entrega = strtotime(date("d-m-Y H:i:00",time()));
$fecha_entrada = strtotime($row['fecha_max_devolucion']);
	
if($fecha_entrega < $fecha_entrada || $fecha_actual > $fecha_entrega){
    $sql = "UPDATE usuarios SET puntaje = (SELECT puntaje)-1 WHERE cedula = ".$row['cc_usuario'];
    $proc->ejecutar_qury($conn, $sql);
    echo "La fecha en la que entrego el usuario excedio la fecha maxima permitida que se le dio, este comportamiento repetitivo
     podria anular la posibilidad de seguir solicitando prestamos de libros.\n";
}

$sql = "UPDATE prestamos
SET estado_prestamo = 'ENTREGADO', fecha_entrega = NOW() 
WHERE id_libro = $id_libro;";
$proc->ejecutar_qury($conn, $sql);
echo "\nEl libro ha sido entregado con exito";

?>