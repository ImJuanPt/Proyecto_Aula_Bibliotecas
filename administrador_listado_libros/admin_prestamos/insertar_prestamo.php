<?php
require_once('../../conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();

$id_libro = mysqli_real_escape_string($conn, $_POST['id_libro']);
$cc_usuario = mysqli_real_escape_string($conn, $_POST['cc_usuario']);
$cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);

$sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario";
$result = $proc->ejecutar_qury($conn,$sql);
$row_insert_prestamo = mysqli_fetch_array($result, MYSQLI_BOTH);

$sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario_sesion";
$result = $proc->ejecutar_qury($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);
echo "
            <html>
            <head>
             <title>Prestamo exitoso </title>
             <meta charset='UTF-8'>
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
             if($row_insert_prestamo['prestamos_activos'] < 5){ //maximo 5 prestamos puede tener el usuario, cuando llegue a 4 es menor que 5 e inserta el quinto y ultimo libro zzz
                if($row_insert_prestamo['puntaje'] >= 1){//puntaje minimo de 1 de 3
                    $sql = "INSERT INTO prestamos (id_libro, cc_usuario) VALUES ($id_libro, $cc_usuario)";
                    $result = $proc->ejecutar_qury($conn, $sql);
                    $sql = "UPDATE usuarios SET prestamos_activos = (SELECT prestamos_activos WHERE cedula = $cc_usuario)+1 WHERE cedula = $cc_usuario";
                    $result = $proc->ejecutar_qury($conn, $sql);

                    echo "<h4>El prestamo se registro con exito </h4>";
                }else{
                    echo "<h4>El usuario ha sido penalizado por mal comportamiento, por tal motivo no se puede realizar el prestamo</h4>";
                }
            }else{
                echo "<h4>El usuario alcanzo el limite de prestamos, por tal motivo no se puede realizar el prestamo</h4>";
            }
        echo "
                <form action='../admin_lista_libros.php' method='post'>
                <input type='hidden' name='cc_usuario_sesion' value='$cc_usuario_sesion'>
                <br><br><button type='submit'>Regresar</button>
                </form>
            </div>
        </div>
";

echo "</body>
</html>";
?>