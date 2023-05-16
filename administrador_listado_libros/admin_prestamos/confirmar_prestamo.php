<?php
require_once('../../conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();

$id_libro = mysqli_real_escape_string($conn, $_POST['id_libro']);
$cc_usuario = mysqli_real_escape_string($conn, $_POST['cedula_solicitante']);
$sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario";
$result = $proc->ejecutar_qury($conn,$sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);

$sql_libro = "SELECT * FROM libros WHERE id_libro = $id_libro";
$result_libro = $proc->ejecutar_qury($conn,$sql_libro);
$row_libro = mysqli_fetch_array($result_libro, MYSQLI_BOTH);

$sql_dia_hora = "SELECT DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i') AS dia_con_hora;";
$result_dia_hora= $proc->ejecutar_qury($conn,$sql_dia_hora);
$row_dia_hora = mysqli_fetch_array($result_dia_hora, MYSQLI_BOTH);

$sql_dia_hora_3= "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 3 DAY), '%Y-%m-%d %H:%i') AS dia_con_hora_3dias;";
$result_dia_hora_3= $proc->ejecutar_qury($conn,$sql_dia_hora_3);
$row_dia_hora_3 = mysqli_fetch_array($result_dia_hora_3, MYSQLI_BOTH);
echo "<html>
    <head>

    </head>
    <body>
        <h5>Libro solicitado: ". $row_libro['nombre']. "</h5>
        <h5>Usuario solicitante: ". $row['nombre']. "</h5>
        <h5>Fecha y hora del prestamo: ". $row_dia_hora['dia_con_hora']. "</h5>
        <h5>Fecha y hora maxima para la entrega del libro: ". $row_dia_hora_3['dia_con_hora_3dias']. "</h5>
        <form action='insertar_prestamo.php' method='post'>
            <input type='hidden' name='id_libro' value='".$id_libro."'>
            <input type='hidden' name='cc_usuario' value='".$cc_usuario."'>
            <button type='submit'>Confirmar prestamo</button>
        </form>
    </body>
</html>";


?>