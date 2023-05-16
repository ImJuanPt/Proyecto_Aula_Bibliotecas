<?php

require_once('conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();
$cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
mysqli_set_charset($conn,"utf8mb4");
$sql = "SELECT usuarios.*, prestamos.*, libros.*
        FROM usuarios 
        INNER JOIN prestamos ON usuarios.cedula = prestamos.cc_usuario
        INNER JOIN libros ON prestamos.id_libro = libros.id_libro
        WHERE usuarios.cedula = $cc_usuario_sesion AND prestamos.estado_prestamo = 'ENTREGADO';";
$result = $proc->ejecutar_qury($conn, $sql);

$sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario_sesion";
$result_2 = $proc->ejecutar_qury($conn, $sql);
$row = mysqli_fetch_array($result_2, MYSQLI_BOTH);

echo "
<!DOCTYPE html>
<html lang='en'>

<head>
    <title>Libros</title>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='libros.css'>
    <link rel='stylesheet' href='vistas.css'>
    <link rel='stylesheet' href='login.css'>
    <link rel='stylesheet' href='prestamo.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <script src='script.js'></script>
</head>

<body>
    <div class='content'>
        <div class='logo'>
            <img src='assets/Images/Logo/image-removebg-preview.png'>
        </div>
        <div class='container-nav'>
            <div class='nav'>
            <form id = 'enviar_datos".$row['cedula']."' action='profile.php' method='post'>
                <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                <a style='cursor: pointer' onclick='submitForm(\"enviar_datos".$row['cedula']."\")'>
                    <img src='Assets/Images/Botones/perfil.png' style = 'margin: auto;margin-left: 55%;'>
                    <p>Perfil</p> 
                </a>
            </form>
            </div>
            <div class='nav'>
                <form id = 'enviar_datos_libro".$row['cedula']."' action='listado_libros.php' method='post'>
                <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                <a style='cursor: pointer' onclick='submitForm(\"enviar_datos_libro".$row['cedula']."\")'>
                    <img src='Assets/Images/Botones/libro.png' style = 'margin: auto;margin-left: 55%;'>
                    <p>Libros</p> 
                </a>
            </form>
            </div>
            <div class='nav'>
                <form id = 'enviar_datos_prestamo".$row['cedula']."' action='prestamo.php' method='post'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <a style='cursor: pointer' onclick='submitForm(\"enviar_datos_prestamo".$row['cedula']."\")'>
                        <img src='Assets/Images/Botones/prestamo.png' style = 'margin: auto;margin-left: 55%;'>
                        <p>Prestamos</p> 
                    </a>
                </form>
            </div>
            <div class='nav'>
            <form id = 'enviar_datos_devolucion".$row['cedula']."' action='devoluciones.php' method='post'>
                <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                <a style='cursor: pointer' onclick='submitForm(\"enviar_datos_devolucion".$row['cedula']."\")'>
                    <img src='Assets/Images/Botones/devolucion.png' style = 'margin: auto;margin-left: 55%;'>
                    <p>Devoluciones</p> 
                </a>
            </form>
            </div>
            <div class='logout'><button><img src='Assets/Images/Botones/salir.png' ></button></div>
        </div>
        

    </div>
    <div class='home'>
        <form id = 'enviar_datos_usuario".$row['cedula']."' action='index.php' method='post'>
            <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
            <a style='cursor: pointer' onclick='submitForm(\"enviar_datos_usuario".$row['cedula']."\")'>
                <img src='Assets/Images/Botones/separador.png' style = 'margin: auto;margin-left: 55%;'>
            </a>
        </form>
    </div>

    <div class='tabla_contenedor'>
        <table>
            <tr>
                <th>Portada</th>
                <th>Nombre</th>
                <th>Fecha prestamo</th>
                <th>Fecha devolución</th>
                <th>Fecha de entrega</th>
            </tr>
            ";
            while($row_prestamo = mysqli_fetch_array($result, MYSQLI_BOTH)){
            echo"
            <tr>
                <td><img style='width: 100px; height: 160px;' src='".$row_prestamo['img_portada']."' alt=''></td>
                <td>".$row_prestamo['nombre']."</td>
                <td>".$row_prestamo['fecha_prestamo']."</td>
                <td>".$row_prestamo['fecha_max_devolucion']."</td>
                <td>".$row_prestamo['fecha_entrega']."</td>

                </tr>";
        }
            echo"
        </table>
    </div>


</body>

</html>
"
?>