<?php
    require_once('../conexion_querys/conexion.php');
    $proc = new proceso();
    $conn = $proc->conn();

    $cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
    $id_libro = $_POST['id_libro'];
    $sql = "SELECT * FROM LIBROS WHERE id_libro = $id_libro"; 
    $result = $proc->ejecutar_qury($conn, $sql);
    $fila = mysqli_fetch_assoc($result);
    $sql = "UPDATE LIBROS SET estado_libro = 'INACTIVO' WHERE id_libro = $id_libro";
    $result = $proc->ejecutar_qury($conn, $sql);
    echo '<script>alert("El libro se elimino de forma exitosa");</script>';
    $proc->volver_listado($cc_usuario_sesion);
?>

