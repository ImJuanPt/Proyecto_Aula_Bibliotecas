<?php
require_once('../conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();
mysqli_set_charset($conn,"utf8mb4");
$cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
$nombre = trim(mysqli_real_escape_string($conn, $_POST['nombre']));
$descripcion = trim(mysqli_real_escape_string($conn, $_POST['desc']));
$autor = trim(mysqli_real_escape_string($conn, $_POST['autor']));
$fecha_publicacion = date("Y-m-d");
$stock = mysqli_real_escape_string($conn, $_POST['stock']);
$generos = $_POST['generos'];

$autor = $_POST["autor"];
$autor = ucwords(strtolower($autor)); // ucwords pasa entre cada espacio la primera letra a mayuscula y le paso de parametro el texto todo en minuscila con strtolower._. 

$sql = "INSERT INTO autores (nombre_autor) SELECT '$autor'
        WHERE NOT EXISTS (SELECT * FROM autores WHERE nombre_autor = '$autor');";

$result = $proc->ejecutar_qury($conn, $sql);

$sql = "SELECT id_autor FROM autores WHERE nombre_autor = '$autor'";
$result = $proc->ejecutar_qury($conn, $sql);
$fila = mysqli_fetch_assoc($result);
$id_autor = $fila['id_autor'];


// Verificar si se ha subido una imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    // Obtener informacion de la imagen
    $name = $_FILES['imagen']['name'];
    $tmp_name = $_FILES['imagen']['tmp_name'];
    $type = $_FILES['imagen']['type'];

    // Verificar si la imagen es valida
    $extensiones_permit = array('jpg', 'jpeg', 'png', 'gif');
    $extension = pathinfo($name, PATHINFO_EXTENSION);
    if (in_array($extension, $extensiones_permit) && is_uploaded_file($tmp_name) && strpos($type, 'image/') === 0) {
        
        $sql = "SELECT * FROM libros";
        $result = $proc->ejecutar_qury($conn, $sql);
        $num_filas_total = mysqli_num_rows($result)+1;
        // Mover la imagen a la carpeta de destino
        $ruta_portada = '../portadas_libros/id_'.$num_filas_total.'_'.$nombre.'_'.$name;
        $ruta_portada = str_replace(' ','',$ruta_portada); //quitar los espacios en blanco
        move_uploaded_file($tmp_name, $ruta_portada);
        $ruta_portada = 'portadas_libros/id_'.$num_filas_total.'_'.$nombre.'_'.$name;
        $ruta_portada = str_replace(' ','',$ruta_portada); //quitar los espacios en blanco
        // Insertar la ruta de la imagen en la base de datos
        $sql = "INSERT INTO libros (nombre, descripcion, fecha_publicacion, id_autor, stock, img_portada) VALUES ('$nombre','$descripcion','$fecha_publicacion','$id_autor','$stock','$ruta_portada')";
        $result = $proc->ejecutar_qury($conn, $sql);
    } else {
        die("Error al subir la imagen. Asegúrate de que seleccionaste un archivo válido. " . mysqli_error($conn));
    }
} 

$sql = "SELECT LAST_INSERT_ID() as ultimo_id;"; //se obtiene el ultimo id de libro insertado para agregar los generos **!cambiar!**
$result = $proc->ejecutar_qury($conn, $sql);
$ultimo_libro = mysqli_fetch_assoc($result);
$id_libro = $ultimo_libro['ultimo_id'];
foreach ($generos as $id_genero) {
    $sql = "INSERT INTO libros_generos (id_libro, id_genero) VALUES ($id_libro, $id_genero)";
    $result = $proc->ejecutar_qury($conn, $sql);
  }
  $sql = "INSERT INTO anuncios(id_libro, tipo_anuncio, descripcion) VALUES ($id_libro, 'Nuevo libro', 'Un nuevo libro ha sido agregado a nuestra biblioteca, puede que sea de su agrado')";
  $proc->ejecutar_qury($conn, $sql);
  mysqli_close($conn);
  echo '<script>alert("El libro se inserto de forma exitosa");</script>';
  $proc->volver_insertar($cc_usuario_sesion);

?>