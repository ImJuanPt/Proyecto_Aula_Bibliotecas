<?php
require_once('../../conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();

$id_libro = mysqli_real_escape_string($conn, $_POST['id_libro']);

$sql = "SELECT * FROM libros WHERE id_libro = $id_libro";
$result = $proc->ejecutar_qury($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);

echo "
<html>
    <head>
        <meta charset='UTF-8'>
        <title>Solicitud prestamo</title>
    </head>

    <body>
        <h5>Libro solicitado:". $row['nombre']. "</h5>
        <form action='confirmar_prestamo.php' method='post' enctype='multipart/form-data'>
            <label>Cedula del solicitante</label>
            <input type='number' name='cedula_solicitante' required>
            <input type='hidden' name='id_libro' value='".$id_libro."'>
            <button type='submit'>Continuar</button>
        </form>
    </body>";


?>
