<?php
require_once('../conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();
mysqli_set_charset($conn,"utf8mb4");
$cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
$sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario_sesion";
$result = $proc->ejecutar_qury($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);

echo "
<html>

<head>
    <meta charset='UTF-8'>
    <title>Insertar libro</title>
    <link rel='stylesheet' type='text/css' href='../complementos/estilo.css'>
    <script src='../script.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='../libros.css'>
        <link rel='stylesheet' href='../vistas.css'>
        <link rel='stylesheet' href='../login.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>


<body>
        <div class='content'>
            <div class='logo'>
                <img src='../assets/Images/Logo/image-removebg-preview.png'>
            </div>
            <div class='container-nav'>
                <div class='nav'>
                <form id = 'enviar_datos".$row['cedula']."' action='profile.php' method='post'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <a style='cursor: pointer' onclick='submitForm(\"enviar_datos".$row['cedula']."\")'>
                        <img src='../Assets/Images/Botones/perfil.png' style = 'margin: auto;margin-left: 55%;'>
                        <p>Perfil</p> 
                    </a>
                </form>
            </div>
            <div class='nav'>
                <form id = 'enviar_datos_libro".$row['cedula']."' action='admin_lista_libros.php' method='post'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <a style='cursor: pointer' onclick='submitForm(\"enviar_datos_libro".$row['cedula']."\")'>
                        <img src='../Assets/Images/Botones/libro.png' style = 'margin: auto;margin-left: 55%;'>
                        <p>Libros</p> 
                    </a>
                </form>
            </div>
            <div class='nav'>
                <form id = 'enviar_datos_insertar_libro".$row['cedula']."' action='admin_insertar_libro_principal.php' method='post'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <a style='cursor: pointer' onclick='submitForm(\"enviar_datos_insertar_libro".$row['cedula']."\")'>
                        <img src='../Assets/Images/Botones/prestamo.png' style = 'margin: auto;margin-left: 55%;'>
                        <p>Registrar libros</p> 
                    </a>
                </form>
            </div>
            
            <div class='logout'><a href = '../procesos_usuario/inicio_sesion_usuario.html'><button><img src='../Assets/Images/Botones/salir.png' ></button><a></div>
        </div>
    </div>
            <div class='contenedor'>";
             echo "<div class='libro_content_insert' id = 'datos'>
             <form action='admin_insertar_libro.php' method='post' enctype='multipart/form-data'>
             <label class='labe' for='nombre'>Nombre</label>
             <input class='labe' type='text' name='nombre' required>
             <label class='labe' for='desc'>Descripcion</label>
             <input class='labe' type='text' name='desc' required>
             <label class='labe' for='autor'>Autor</label>
             <input class='labe' type='text' name='autor' required>
             <label class='labe' for='stock'>Stock</label>
             <input class='labe' type='number' name='stock' required><br>
             <label class='checkbx'>Seleccione uno o varios geneross:</label>
             <div class='contenedor_checkbox'>";
                 $sql = 'SELECT * FROM generos';
                 $result = $proc->ejecutar_qury($conn, $sql);
                 $i = 0;
                 while ($row = mysqli_fetch_assoc($result)) {
                   if ($i % 5 == 0) {
                     echo "<div class='columna_chck'>";
                   }
                   echo "<div><label style = 'cursor: pointer'><input class='checkbox' type='checkbox' name='generos[]' value='".$row['id_genero']."'>".$row['nombre_genero']."</label></div>";
                   $i++;
                   if ($i % 5 == 0) {
                     echo '</div>';
                   }
                 }
     echo"    </div>
     </div>
             <label class='labe' for='nombre'>Portada</label>
             <img class='imagen_register' id='vista-previa' src='#' alt='Vista previa de imagen' style='display: none; width: 112px; margin-rigth: 100%;'><br>
             <input type='file' name='imagen' id='imagen' accept='image/*' required>
             <input type='hidden' name='cc_usuario_sesion' value='$cc_usuario_sesion'>
             <button class='labe' id='btn_registrar' type='submit' class='btn btn-primary'>
                 Registrar libro
             </button>
         </form>
                    </div>";
      echo "</div>
        </body>
</html>
";
?>