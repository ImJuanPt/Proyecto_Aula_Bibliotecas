<?php
    require_once('../conexion_querys/conexion.php');
    $proc = new proceso();
    $conn = $proc->conn();
    mysqli_set_charset($conn,"utf8mb4");

    $cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
    $busqueda = mysqli_real_escape_string($conn, $_POST['texto_busqueda']);
    $opcion = $_POST['opcion_busqueda'];

        $sql = "SELECT *, autores.* FROM libros 
        INNER JOIN autores ON libros.id_autor = autores.id_autor
        WHERE $opcion LIKE '$busqueda%'";
        $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));

        echo "

    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Administracion libros</title>
        <script src='../script.js'></script>
        <meta http-equiv='Cache-Control' content='no-cache, must-revalidate'>
    </head>
    <body>
    <div class = 'consulta'>
                <form action='resultado_busqueda.php' method='post'>
                    <input type='text' name='texto_busqueda' value = '$busqueda'>
                    <select name='opcion_busqueda'>
                        <option value='nombre'>Nombre del libro</option>
                        <option value='nombre_autor'>Nombre de Autor</option>
                    </select>
                    <input type='hidden' name='cc_usuario_sesion' value='".$cc_usuario_sesion."'>
                    <button type='submit'>Buscar</button>
                </form>
            </div>
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
                        <form id='form-libro-eliminar".$row['id_libro']."' action='admin_eliminar_libro.php' method='POST' style='display: inline-block; margin-right: 15px; margin-left: 15px;'>
                            <input type='hidden' name='id_libro' value='".$row['id_libro']."'>
                            <img src='../iconos/eliminar.png' title='Eliminar' style='width: 20px; cursor: pointer' onclick='confirmarEliminacion(\"form-libro-eliminar".$row['id_libro']."\")'>
                        </form>
                        <form id='form-libro-editar-".$row['id_libro']."' action='admin_editar_libro.php' method='POST' style='display: inline-block; margin-right: 15px;'>
                            <input type='hidden' name='id_libro' value='".$row['id_libro']."'>
                            <img src='../iconos/editar.png' title='Editar' style='width: 20px; cursor: pointer' onclick='submitForm(\"form-libro-editar-".$row['id_libro']."\")'>
                        </form>
                        <form id='form-libro-generar_prestamo-".$row['id_libro']."' action='admin_prestamos/solicitar_prestamo.php' method='POST' style='display: inline-block; margin-right: 15px;'>
                            <input type='hidden' name='id_libro' value='".$row['id_libro']."'> 
                            <input type='hidden' name='cc_usuario_sesion' value='".$cc_usuario_sesion."'>
                            <img src='../iconos/generar_prestamo.png' title='Generar prestamo' style='width: 20px; cursor: pointer' onclick='submitForm(\"form-libro-generar_prestamo-".$row['id_libro']."\")'>
                        </form>
                        <form id='form-libro-prestamos_libro-".$row['id_libro']."' action='admin_prestamos/admin_entrega_libro/admin_lista_prestamos.php' method='POST' style='display: inline-block;'>
                            <input type='hidden' name='id_libro' value='".$row['id_libro']."'>
                            <input type='hidden' name='cc_usuario_sesion' value='".$cc_usuario_sesion."'>
                            <img src='../iconos/prestamos_libros.png' title='Prestamos del libro' style='width: 20px; cursor: pointer' onclick='submitForm(\"form-libro-prestamos_libro-".$row['id_libro']."\")'>
                        </form>
                    </td>
                </tr>";
            }
    echo "
    </table>
    

    </body>";

?>