<?php
    require_once('../../../conexion_querys/conexion.php');
    $proc = new proceso();
    $conn = $proc->conn();
    mysqli_set_charset($conn,"utf8mb4");

    $id_libro = mysqli_real_escape_string($conn, $_POST['id_libro']);
    $cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
    $sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario_sesion";
    $result = $proc->ejecutar_qury($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_BOTH);

    $sql = "SELECT *,usuarios.nombre AS nombre_usuario, usuarios.cedula , libros.nombre AS nombre_libro, autores.nombre_autor FROM prestamos 
            INNER JOIN libros ON prestamos.id_libro = libros.id_libro
            INNER JOIN autores ON libros.id_autor = autores.id_autor
            INNER JOIN usuarios ON prestamos.cc_usuario = usuarios.cedula
            WHERE libros.id_libro = $id_libro;";
    $result = $proc->ejecutar_qury($conn, $sql);
    $num_filas = mysqli_num_rows($result);
    echo "
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Administracion libros</title>
        <script src='../../../script.js'></script>
        <meta http-equiv='Cache-Control' content='no-cache, must-revalidate'>
        <link rel='stylesheet' href='ccs_tabla.css'><script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='../../../libros.css'>
        <link rel='stylesheet' href='../../../vistas.css'>
        <link rel='stylesheet' href='../../../login.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    </head>
        <body>
        <div class='content'>
            <div class='logo'>
                <img src='../../../assets/Images/Logo/image-removebg-preview.png'>
            </div>
            <div class='container-nav'>
                <div class='nav'>
                <form id = 'enviar_datos".$row['cedula']."' action='../../profile.php' method='post'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <a style='cursor: pointer' onclick='submitForm(\"enviar_datos".$row['cedula']."\")'>
                        <img src='../../../Assets/Images/Botones/perfil.png' style = 'margin: auto;margin-left: 55%;'>
                        <p>Perfil</p> 
                    </a>
                </form>
            </div>
            <div class='nav'>
                <form id = 'enviar_datos_libro".$row['cedula']."' action='../../admin_lista_libros.php' method='post'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <a style='cursor: pointer' onclick='submitForm(\"enviar_datos_libro".$row['cedula']."\")'>
                        <img src='../../../Assets/Images/Botones/libro.png' style = 'margin: auto;margin-left: 55%;'>
                        <p>Libros</p> 
                    </a>
                </form>
            </div>
            <div class='nav'>
                <form id = 'enviar_datos_insertar_libro".$row['cedula']."' action='../../admin_insertar_libro_principal.php' method='post'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <a style='cursor: pointer' onclick='submitForm(\"enviar_datos_insertar_libro".$row['cedula']."\")'>
                        <img src='../../../Assets/Images/Botones/prestamo.png' style = 'margin: auto;margin-left: 55%;'>
                        <p>Registrar libros</p> 
                    </a>
                </form>
            </div>
            
            <div class='logout'><a href = '../../../procesos_usuario/inicio_sesion_usuario.html'><button><img src='../../../Assets/Images/Botones/salir.png' ></button></a></div>
        </div>
    </div>
    <div class='welcome'>
        <div class = 'consulta'>
                <form action='../../../resultado_busqueda.php' method='post'>
                    <input type='text' name='texto_busqueda'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <select name='opcion_busqueda'>
                        <option value='nombre'>Nombre</option>
                        <option value='nombre_autor'>Autor</option>
                    </select>
                    <button type='submit'>Buscar</button>
                </form>
            </div>
    </div>
        <div class='contenedor2'>
            <table class='rwd-table' style = 'margin-left: 45px;'>
            <tr>
                <th>Nombre prestador</th>
                <th>Cedula</th>
                <th>Nombre libro</th>
                <th>Autor</th>
                <th>Fecha prestamo</th>
                <th>Fecha max entrega</th>
                <th>Estado de prestamo</th>
                <th>Entregar libro</th>
            </tr>";
        if($num_filas > 0){
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            echo "<tr>
                    <td>".$row['nombre_usuario'] . "</td>
                    <td>".$row['cedula'] . "</td>
                    <td>".$row['nombre_libro'] . "</td>
                    <td>".$row['nombre_autor']."</td>
                    <td>".$row['fecha_prestamo']."</td>
                    <td>".$row['fecha_max_devolucion']."</td>
                    <td>".$row['estado_prestamo']."</td>";
                    if($row['estado_prestamo']==="NO ENTREGADO"){
                    echo "
                    <form id='form-libro-entrega".$row['id_prestamo']."' action='admin_entrega_prestamo.php' method='POST' style='display: inline-block; margin-right: 15px; margin-left: 15px;'>
                    <td>
                        <input type='hidden' name='id_libro' value='".$row['id_libro']."'>
                        <input type='hidden' name='id_prestamo' value='".$row['id_prestamo']."'>
                        <input type='hidden' name='cc_usuario_sesion' value='$cc_usuario_sesion'>
                        <center><img src='../../../iconos/dar_libro.png' title='Entrega de libro' style='width: 30px; cursor: pointer' onclick='submitForm(\"form-libro-entrega".$row['id_prestamo']."\")'><center>
                    </td>    
                    </form>
                </tr>";
                }
            }
        }else{
            echo "<tr><td>El libro seleccionado no tiene ningun prestamo </td></tr>";
        }
echo "      </table>
            </div>
        </div>
    </body>";
?>