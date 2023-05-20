<?php
require_once('conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();
$cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
mysqli_set_charset($conn,"utf8mb4");
$sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario_sesion";
$result = $proc->ejecutar_qury($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);

$sql_anuncio = "SELECT anuncios.*, libros.nombre, libros.img_portada FROM anuncios 
                INNER JOIN libros ON anuncios.id_libro = libros.id_libro 
                ORDER BY anuncios.id_libro DESC 
                LIMIT 3;";
$resultado_anuncio = $proc->ejecutar_qury($conn, $sql_anuncio);

// Almacenar los resultados en un arreglo
$datos = array();
while ($fila_anuncio = mysqli_fetch_assoc($resultado_anuncio)) {
    $datos[] = $fila_anuncio;
}

echo "
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='login.css'>
    <title>Libread</title>
    <script src='script.js'></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
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
            <div class='logout'><a href = 'procesos_usuario/inicio_sesion_usuario.html'><button><img src='Assets/Images/Botones/salir.png' ></button><a></div>
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
    <div class='welcome'>
        <div>
            <p class='bienvenido'>Bienvenido ".$row['nombre']."!</p>
            <p class='aventura'>¿Que aventura tendrás el día de hoy?</p>
        </div>
    </div>
    <div class='notices'>

        <div class='content_notices'>
            <div class='noticias'>
                <p class='titulo'>". $datos[0]['tipo_anuncio']."</p>
                <img src='".$datos[0]['img_portada']."' alt=''>
                <p class='descripcion'> ".$datos[0]['descripcion']."</p>
            </div>
        </div>
        <div class='notices2'>
            <div class='content_notices'>
                <div class='noticias'>
                    <p class='titulo'>". $datos[1]['tipo_anuncio']."</p>
                    <img src='".$datos[1]['img_portada']."' alt=''>
                    <p class='descripcion'> ".$datos[1]['descripcion']."</p>
                </div>
            </div>
            <div class='notices3'>
                <div class='content_notices'>
                    <div class='noticias'>
                    <p class='titulo'>". $datos[2]['tipo_anuncio']."</p>
                    <img src='".$datos[2]['img_portada']."' alt=''>
                    <p class='descripcion'> ".$datos[2]['descripcion']."</p>
                    </div>
                </div>
            </div>
</body>

</html>
";
?>
