<?php
    require_once('../conexion_querys/conexion.php');
    $proc = new proceso();
    $conn = $proc->conn();

    $id_libro = $_POST['id_libro'];
    $sql = "SELECT * FROM LIBROS WHERE id_libro = $id_libro"; 
    $result = $proc->ejecutar_qury($conn, $sql);
    $fila = mysqli_fetch_assoc($result);
    
    $ruta_archivo = "../".$fila['img_portada'];
    if (file_exists($ruta_archivo)) {
        $sql = "UPDATE LIBROS SET estado_libro = 'INACTIVO' WHERE id_libro = $id_libro";
        $result = $proc->ejecutar_qury($conn, $sql);
        if ($result) {
            mysqli_close($conn);
            echo '<script>alert("El libro se elimino de forma exitosa");</script>';
            echo '<!DOCTYPE html>
            <html>
            <head>
            <title>Libro eliminado </title>
            </head>
            <body onload="volver()">
            <script>
            function volver() {
                window.history.back();
            }
            </script>
            </body>
            </html>';
        }
    } else {
        echo "El archivo no existe en la ubicación especificada.";
    }
?>

