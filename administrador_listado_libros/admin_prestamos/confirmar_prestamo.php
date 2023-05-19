<?php
require_once('../../conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();
mysqli_set_charset($conn,"utf8mb4");
date_default_timezone_set('America/Bogota'); 

$id_libro = mysqli_real_escape_string($conn, $_POST['id_libro']);
$cc_usuario = mysqli_real_escape_string($conn, $_POST['cedula_solicitante']);
$cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);

$sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario";
$result = $proc->ejecutar_qury($conn,$sql);
$row_usuario_prestamo = mysqli_fetch_array($result, MYSQLI_BOTH);
$num_filas = mysqli_num_rows($result);

$sql_libro = "SELECT * FROM libros WHERE id_libro = $id_libro";
$result_libro = $proc->ejecutar_qury($conn,$sql_libro);
$row_libro = mysqli_fetch_array($result_libro, MYSQLI_BOTH);

$sql_dia_hora = "SELECT DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i') AS dia_con_hora;";
$result_dia_hora= $proc->ejecutar_qury($conn,$sql_dia_hora);
$row_dia_hora = mysqli_fetch_array($result_dia_hora, MYSQLI_BOTH);

$sql_dia_hora_3= "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 3 DAY), '%Y-%m-%d %H:%i') AS dia_con_hora_3dias;";
$result_dia_hora_3= $proc->ejecutar_qury($conn,$sql_dia_hora_3);
$row_dia_hora_3 = mysqli_fetch_array($result_dia_hora_3, MYSQLI_BOTH);


$id_libro = mysqli_real_escape_string($conn, $_POST['id_libro']);

$sql = "SELECT * FROM libros WHERE id_libro = $id_libro";
$result = $proc->ejecutar_qury($conn, $sql);
$row_libro = mysqli_fetch_array($result, MYSQLI_BOTH);

$sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario_sesion";
$result = $proc->ejecutar_qury($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);
echo "
<html>

<head>
    <meta charset='UTF-8'>
    <title>Solicitar prestamo de libro</title>
    <link rel='stylesheet' type='text/css' href='../../complementos/estilo.css'>
    <script src='../../script.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='../../libros.css'>
        <link rel='stylesheet' href='../../vistas.css'>
        <link rel='stylesheet' href='../../login.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>


<body>
        <div class='content'>
            <div class='logo'>
                <img src='../../assets/Images/Logo/image-removebg-preview.png'>
            </div>
            <div class='container-nav'>
                <div class='nav'>
                <form id = 'enviar_datos".$row['cedula']."' action='profile.php' method='post'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <a style='cursor: pointer' onclick='submitForm(\"enviar_datos".$row['cedula']."\")'>
                        <img src='../../Assets/Images/Botones/perfil.png' style = 'margin: auto;margin-left: 55%;'>
                        <p>Perfil</p> 
                    </a>
                </form>
            </div>
            <div class='nav'>
                <form id = 'enviar_datos_libro".$row['cedula']."' action='admin_lista_libros.php' method='post'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <a style='cursor: pointer' onclick='submitForm(\"enviar_datos_libro".$row['cedula']."\")'>
                        <img src='../../Assets/Images/Botones/libro.png' style = 'margin: auto;margin-left: 55%;'>
                        <p>Libros</p> 
                    </a>
                </form>
            </div>
            <div class='nav'>
                <form id = 'enviar_datos_insertar_libro".$row['cedula']."' action='admin_insertar_libro_principal.php' method='post'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <a style='cursor: pointer' onclick='submitForm(\"enviar_datos_insertar_libro".$row['cedula']."\")'>
                        <img src='../../Assets/Images/Botones/prestamo.png' style = 'margin: auto;margin-left: 55%;'>
                        <p>Registrar libros</p> 
                    </a>
                </form>
            </div>
            
            <div class='logout'><a href = '../../procesos_usuario/inicio_sesion_usuario.html'><button><img src='../../Assets/Images/Botones/salir.png' ></button><a></div>
        </div>
    </div>
            <div class='contenedor'>";
             echo "<div class='libro_content_prestamo_2' id = 'datos'>";
            if($num_filas > 0){
             echo "<h3>Libro solicitado: ". $row_libro['nombre']. "</h3><br>
             <h4>Usuario solicitante: ". $row_usuario_prestamo['nombre']. "</h4> <br>
             <h4>Fecha del prestamo: ".$row_dia_hora['dia_con_hora']. "</h4><br>
             <h4>Fecha maxima para la entrega del libro: ".$row_dia_hora_3['dia_con_hora_3dias']."</h4><br>
             <form action='insertar_prestamo.php' method='post'>
                <input type='hidden' name='id_libro' value='".$id_libro."'>
                <input type='hidden' name='cc_usuario' value='".$cc_usuario."'>
                <input type='hidden' name='cc_usuario_sesion' value='".$cc_usuario_sesion."'>
                <button type='submit'>Confirmar prestamo</button>
            </form>
                </div>";
            }else{
                echo "<h4>La cedula que ingreso '$cc_usuario' no se encuentra registrada, verifiquela e intentelo de nuevo.</h4>
                <form action='solicitar_prestamo.php' method='post'>
                <input type='hidden' name='id_libro' value='".$id_libro."'>
                <input type='hidden' name='cc_usuario_sesion' value='".$cc_usuario_sesion."'>
                <br><button style='width: 91px;' type='submit'>Volver</button>
                </form>
                ";
                
            }
      echo "</div>
        </body>
</html>";
?>

