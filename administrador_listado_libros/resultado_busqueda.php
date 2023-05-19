<?php
 require_once('../conexion_querys/conexion.php');
 $proc = new proceso();
 $conn = $proc->conn();
 mysqli_set_charset($conn,"utf8mb4");
 $cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
 $busqueda = mysqli_real_escape_string($conn, $_POST['texto_busqueda']);
 $opcion = $_POST['opcion_busqueda'];
 
 $sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario_sesion";
 $result = $proc->ejecutar_qury($conn, $sql);
 $row = mysqli_fetch_array($result, MYSQLI_BOTH);
 

    $sql = "SELECT libros.*, autores.nombre_autor FROM libros 
            INNER JOIN autores ON libros.id_autor = autores.id_autor
            WHERE $opcion LIKE '$busqueda%' AND estado_libro = 'ACTIVO';";
            
    $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));

    echo "
    <!DOCTYPE html>
    <html>
    <head>
    
        <meta charset='UTF-8'>
        <title>Libros</title>
        <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='../libros.css'>
        <link rel='stylesheet' href='../vistas.css'>
        <link rel='stylesheet' href='../login.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <script src='../script.js'></script>
        <meta http-equiv='Cache-Control' content='no-cache, must-revalidate'>
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
            
            <div class='logout'><a href = '../procesos_usuario/inicio_sesion_usuario.html'><button><img src='../Assets/Images/Botones/salir.png' ></button></a></div>
        </div>
    </div>
    <div class='welcome'>
        <div class = 'consulta'>
                <form action='resultado_busqueda.php' method='post'>
                    <input type='text' name='texto_busqueda' value = '$busqueda'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                    <select name='opcion_busqueda'>
                        <option value='nombre'>Nombre</option>
                        <option value='nombre_autor'>Autor</option>
                    </select>
                    <button type='submit'>Buscar</button>
                </form>
            </div>
    </div>
    <div class='contenedor2'>";
    while($row_libro = mysqli_fetch_array($result,MYSQLI_BOTH)){
     echo "<div class='libro_content' id = 'datos'>
                <form id='form-libro-".$row_libro['id_libro']."' action='../descripcion_libro_seleccionado.php' method='POST'>
                    <input type='hidden' name='id_libro' value='".$row_libro['id_libro']."'>
                    <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                        <p class='titulo' style='cursor: pointer' onclick='submitForm(\"form-libro-".$row_libro['id_libro']."\")'>".$row_libro['nombre']."</p>
                        <img class='portada' src='../".$row_libro['img_portada']."' title='".$row_libro['descripcion']."' style='width: 160px; height: 210px; cursor: pointer' onclick='submitForm(\"form-libro-".$row_libro['id_libro']."\")'><br>
                        <p class='descripcion'>Descripcion: ".$row_libro['descripcion']."</p><br><br>
                        <p class='descripcion'> Autor: ".$row_libro['nombre_autor']."</p>
                        <p class='descripcion'>Stock: ".$row_libro['stock']."</p>
                        
                    </form>
                        <form id='form-libro-eliminar".$row_libro['id_libro']."' action='admin_eliminar_libro.php' method='POST' style='display: inline-block; margin-right: 15px; margin-left: 15px;'>
                            <input type='hidden' name='id_libro' value='".$row_libro['id_libro']."'>
                            <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                            <button class='prestar'> <img src='../iconos/eliminar.png' title='Eliminar' onclick='confirmarEliminacion(\"form-libro-eliminar".$row_libro['id_libro']."\")'></button>
                        </form>
                        <form id='form-libro-editar-".$row_libro['id_libro']."' action='admin_editar_libro.php' method='POST' style='display: inline-block; margin-right: 15px;'>
                            <input type='hidden' name='id_libro' value='".$row_libro['id_libro']."'>
                            <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                            <button class='prestar'><img src='../iconos/editar.png' title='Editar' onclick='submitForm(\"form-libro-editar-".$row_libro['id_libro']."\")'></button>
                        </form>
                        <form id='form-libro-generar_prestamo-".$row_libro['id_libro']."' action='admin_prestamos/solicitar_prestamo.php' method='POST' style='display: inline-block; margin-right: 15px;'>
                            <input type='hidden' name='id_libro' value='".$row_libro['id_libro']."'> 
                            <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                            <button class='prestar'><img src='../iconos/generar_prestamo.png' title='Generar prestamo' onclick='submitForm(\"form-libro-generar_prestamo-".$row_libro['id_libro']."\")'></button>
                        </form>
                        <form id='form-libro-prestamos_libro-".$row_libro['id_libro']."' action='admin_prestamos/admin_entrega_libro/admin_lista_prestamos.php' method='POST' style='display: inline-block;'>
                            <input type='hidden' name='id_libro' value='".$row_libro['id_libro']."'>
                            <input type='hidden' name='cc_usuario_sesion' value='".$row['cedula']."'>
                            <button class='prestar'><img src='../iconos/prestamos_libros.png' title='Generar entrega' onclick='submitForm(\"form-libro-prestamos_libro-".$row_libro['id_libro']."\")'></button>
                        </form>
                </form>
            </div>";
    }

echo "</div>
</body>
</html>";
?>