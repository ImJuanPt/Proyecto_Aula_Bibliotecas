<?php
    $conn = mysqli_connect("localhost", "root","","db_gestor_bibliotecas");
    $id_libro = $_POST['id_libro'];
    $sql = "SELECT * FROM LIBROS WHERE id_libro = $id_libro"; 
    $result = mysqli_query($conn,$sql);
    $fila = mysqli_fetch_assoc($result);
    
    $ruta_archivo = "../".$fila['img_portada'];
    if (file_exists($ruta_archivo)) {
        unlink($ruta_archivo);
        
        $sql = "UPDATE LIBROS SET estado_libro = 'INACTIVO' WHERE id_libro = $id_libro";
        $result = mysqli_query($conn,$sql);
        if (!$result) {
            echo "Error al eliminar el registro: " . mysqli_error($conn);
        }else{
            mysqli_close($conn);
            echo "<script>alert('Se elimino el libro de forma exitosa'); 
            window.location='http://localhost/proyecto_aula_bibliotecav2/administrador_listado_libros/admin_lista_libros.php';
            </script>";
        }
    } else {
        echo "El archivo no existe en la ubicación especificada.";
    }
?>

