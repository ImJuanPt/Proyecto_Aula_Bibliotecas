<?php
    $conn = mysqli_connect("localhost", "root", "", "db_gestor_bibliotecas");
    if (!$conn) {
        echo "Error No: " . mysqli_connect_errno();
        echo "Error Description: " . mysqli_connect_error();
        exit;
    }
    mysqli_set_charset($conn,"utf8mb4");
    $sql = "SELECT *, autores.nombre_autor FROM libros 
            INNER JOIN autores ON libros.id_autor = autores.id_autor;";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
    echo "
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Administracion libros</title>
        <script src='../script.js'></script>
    </head>
    <body>
    <table border = '2'>
        <tr>
            <th>id</th>
            <th>Nombre</th>
            <th>Autor</th>
            <th>Stock</th>
            <th>Fecha Publicacion</th>
            <th>Administracion</th>
            </tr>";
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo "<tr>
                    <td>".$row['id_libro'] . "</td>
                    <td>".$row['nombre'] . "</td>
                    <td>".$row['nombre_autor']."</td>
                    <td>".$row['stock']."</td>
                    <td>".$row['fecha_publicacion']."</td>
                    <td class = 'administracion_iconos'>
                        <form id='form-libro-".$row['id_libro']."' action='admin_eliminar_libro.php' method='POST' style='display: inline-block; margin-right: 15px; margin-left: 15px;'>
                            <input type='hidden' name='id_libro' value='".$row['id_libro']."'>
                            <img src='../iconos/eliminar.png' title='Eliminar' style='width: 20px; cursor: pointer' onclick='submitForm(\"form-libro-".$row['id_libro']."\")'>
                        </form>
                        <form id='form-libro-editar-".$row['id_libro']."' action='admin_editar_libro.php' method='POST' style='display: inline-block;'>
                            <input type='hidden' name='id_libro' value='".$row['id_libro']."'>
                            <img src='../iconos/editar.png' title='Editar' style='width: 20px; cursor: pointer' onclick='submitForm(\"form-libro-editar-".$row['id_libro']."\")'>
                        </form>
                    </td>
                </tr>";
            }
    echo "
    <body>
    </table>";

?>