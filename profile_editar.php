<?php
require_once('conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();
$cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
mysqli_set_charset($conn,"utf8mb4");
$sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario_sesion";
$result = $proc->ejecutar_qury($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);
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
    
    <div class='content_profile'>
        <div class='backgroundimage'> <img class='imagenperfil' src='Assets/Images/Botones/usuario.png'></div>
        <p>Puntos:</p>
        <p>Nombre:</p>
        <p>Primer apellido:</p>
        <p>Segundo apellido:</p>
        <p>Cedula:</p>
        <p>Correo:</p>
        <p>Contraseña:</p>
        <button id='ver_pass'; onclick='mostrar_contra();'><img class='ver_contra'
        src='Assets/Images/Botones/ojo.png'></button>

        <button id='ocultar_pass' onclick='quitar_contra();'> <img class='ver_contra' src='Assets/Images/Botones/ojos-cruzados.png'>
        </button>
                
        <div class='user_info' >
            <form action='profile_edit_insert.php' method='post'>
                <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                <p class='puntos' id ='user_info_edit'>". $row['puntaje']."</p> 
                <p class='nombre' id='user_info_edit'><input  name = 'nombre' type = 'text' value ='". $row['nombre']."'></p>
                <p class='apellido' id='user_info_edit'><input  name = 'apellido1' type = 'text' value ='". $row['apellido_1']."'</p><br>
                <p class='apellido' id='user_info_edit'><input  name = 'apellido2' type = 'text' value ='". $row['apellido_2']."'</p><br>
                <p class='cedula' id='user_info_edit'><input  name = 'cedula' type = 'number' value ='". $row["cedula"]."'</p><br>
                <p class='correo' id='user_info_edit'><input  name = 'email' type = 'email' value ='". $row["correo"]."'</p><br>
                <p id='contraseña' ><input  name = 'contra' type = 'text' value ='". $row["passw"]."'></p><br>
                <button type = 'submit' class=editar;> <img class='editar' src='Assets/Images/Botones/lapiz-de-usuario.png'></button>
            </form>
        </div>
    </div>

    <script>
        function mostrar_contra() {
            document.getElementById('contraseña').style.opacity = 1;
            document.getElementById('ocultar_pass').style.display = 'block';
        }

        function quitar_contra() {
            document.getElementById('contraseña').style.opacity = 0;
            document.getElementById('ocultar_pass').style.display = 'none';
        }
    </script>
</body>

</html>
";
?>