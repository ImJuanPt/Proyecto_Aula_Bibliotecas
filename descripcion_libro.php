<?php
    require_once('conexion_querys/conexion.php');
    $proc = new proceso();
    $conn = $proc->conn();

    $id_libro = $_POST['id_libro'];
    mysqli_set_charset($conn,"utf8mb4");
    $sql = "SELECT generos.nombre_genero 
    FROM libros_generos 
    INNER JOIN generos ON libros_generos.id_genero = generos.id_genero 
    WHERE libros_generos.id_libro = '$id_libro';";
    $result = $proc->ejecutar_qury($conn, $sql);
    $generos = '';
    while($row = mysqli_fetch_array($result,MYSQLI_BOTH)){
        if($generos===''){
            $generos = $row['nombre_genero'];
        }else{
            $generos = $generos.", ".$row['nombre_genero'];
        }
    }
    $sql = "SELECT *, autores.nombre_autor FROM libros 
            INNER JOIN autores ON libros.id_autor = autores.id_autor 
            WHERE id_libro = '$id_libro'";
    $result = $proc->ejecutar_qury($conn, $sql);
    $fila = mysqli_fetch_array($result);

    echo " 
    <h4>Nombre: ".$fila['nombre']."</h4>
    <h4>Descripcion: ".$fila['descripcion']."</h4>
    <h4>Stock: ".$fila['stock']."</h4>
    <h4>Autor: ".$fila['nombre_autor']."</h4>
    <h4>Fecha de publicacion: ".$fila['fecha_publicacion']."</h4>
    <h4>Generos: ".$generos."</h4>
    <h4>Portada:</h4> <img src='".$fila['img_portada']."' alt='' style='width: 150px;'>
    
    ";
?>