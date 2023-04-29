<?php
    $conn = mysqli_connect('localhost', 'root', '', 'db_gestor_bibliotecas');
    if (!$conn) {
        die("Error al conectar a la base de datos: " . mysqli_connect_error());
    }
    $id_libro = $_POST['id_libro'];
    mysqli_set_charset($conn,"utf8mb4");
    $sql = "SELECT generos.nombre_genero 
    FROM libros_generos 
    INNER JOIN generos ON libros_generos.id_genero = generos.id_genero 
    WHERE libros_generos.id_libro = '$id_libro';";
    $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $generos = "";
    while($row = mysqli_fetch_array($result,MYSQLI_BOTH)){
        $generos = $generos.", ".$row['nombre_genero'];
    }
    $sql = "SELECT *, autores.nombre_autor FROM libros 
            INNER JOIN autores ON libros.id_autor = autores.id_autor 
            WHERE id_libro = '$id_libro'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
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