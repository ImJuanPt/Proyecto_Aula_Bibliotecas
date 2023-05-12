<?php
    require_once('../../../conexion_querys/conexion.php');
    $proc = new proceso();
    $conn = $proc->conn();
    mysqli_set_charset($conn,"utf8mb4");

    $id_libro = mysqli_real_escape_string($conn, $_POST['id_libro']);
    
    $sql = "SELECT *,usuarios.nombre AS nombre_usuario, usuarios.cedula , libros.nombre AS nombre_libro, autores.nombre_autor FROM prestamos 
            INNER JOIN libros ON prestamos.id_libro = libros.id_libro
            INNER JOIN autores ON libros.id_autor = autores.id_autor
            INNER JOIN usuarios ON prestamos.cc_usuario = usuarios.cedula
            WHERE libros.id_libro = $id_libro;";
    $result = $proc->ejecutar_qury($conn, $sql);

    echo "
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Administracion libros</title>
        <script src='../script.js'></script>
        <meta http-equiv='Cache-Control' content='no-cache, must-revalidate'>
    </head>
    <body>
    <table border = '2'>
        <tr>
            <th>Nombre prestador</th>
            <th>Cedula</th>
            <th>Nombre libro</th>
            <th>Autor</th>
            <th>Fecha prestamo</th>
            <th>Fecha max entrega</th>
            <th>Estado de prestamo</th>
            </tr>";
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo "<tr>
                        <td>".$row['nombre_usuario'] . "</td>
                        <td>".$row['cedula'] . "</td>
                        <td>".$row['nombre_libro'] . "</td>
                        <td>".$row['nombre_autor']."</td>
                        <td>".$row['fecha_prestamo']."</td>
                        <td>".$row['fecha_max_devolucion']."</td>
                        <td>".$row['estado_prestamo']."</td>
                    </tr>";
            }
    echo "
    </table>
    

    </body>";

?>