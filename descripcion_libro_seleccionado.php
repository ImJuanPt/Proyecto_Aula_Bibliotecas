<?php
 require_once('conexion_querys/conexion.php');
 $proc = new proceso();
 $conn = $proc->conn();
 mysqli_set_charset($conn,"utf8mb4");
 $cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
 $id_libro = $_POST['id_libro'];

 $sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario_sesion";
 $result = $proc->ejecutar_qury($conn, $sql);
 $row = mysqli_fetch_array($result, MYSQLI_BOTH);

 $sql = "SELECT libros.*, autores.nombre_autor FROM libros 
        INNER JOIN autores ON libros.id_autor = autores.id_autor
        WHERE estado_libro = 'ACTIVO' AND id_libro = $id_libro;";
 $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
 $row_libro = mysqli_fetch_array($result,MYSQLI_BOTH);

 $sql = "SELECT generos.nombre_genero 
 FROM libros_generos 
 INNER JOIN generos ON libros_generos.id_genero = generos.id_genero 
 WHERE libros_generos.id_libro = '$id_libro';";
 $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
 $generos = '';
    while($row_genero = mysqli_fetch_array($result,MYSQLI_BOTH)){
        if($generos===''){
            $generos = $row_genero['nombre_genero'];
        }else{
            $generos = $generos.", ".$row_genero['nombre_genero'];
        }
    }

    echo "
    <!DOCTYPE html>
    <html>
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
    <div class='welcome'>
        <div class = 'consulta'>
                <form action='resultado_busqueda.php' method='post'>
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
        <div class='contenedor'>";
         echo "<div class='libro_content'>
                    <input type='hidden' name='id_libro' value='".$row_libro['id_libro']."'><p class='titulo'>".$row_libro['nombre']."</p>
                            <img class='portada' src='".$row_libro['img_portada']."' title='".$row_libro['descripcion']."' style='width: 160px; height: 210px;'><br>
                            <p class='descripcion'>Descripcion: ".$row_libro['descripcion']."</p><br><br>
                            <p class='descripcion'> Autor: ".$row_libro['nombre_autor']."</p>
                            <p class='descripcion'>Stock: ".$row_libro['stock']."</p>
                            <p class='descripcion'>Fecha de publicacion: ".$row_libro['fecha_publicacion']."</p>
                            <p class='descripcion'>Generos: ".$generos."</p>
                </div>";
      echo "</div>
        </body>
    </html>";
?>