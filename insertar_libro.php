<?php


$conn = mysqli_connect('localhost', 'root', '', 'db_gestor_bibliotecas');
if (!$conn) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
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

$result = mysqli_query($conn, $sql) or die(header('Location: notificacion_resultado_libro.php?mensaje=error'));

$sql = "SELECT id_autor FROM autores WHERE nombre_autor = '$autor'";
$result = mysqli_query($conn, $sql) or die(header('Location: notificacion_resultado_libro.php?mensaje=error'));
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
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $num_filas_total = mysqli_num_rows($result)+1;
        // Mover la imagen a la carpeta de destino
        $ruta_portada = 'portadas_libros/id_'.$num_filas_total.'_'.$nombre.'_'.$name;
        $ruta_portada = str_replace(' ','',$ruta_portada); //quitar los espacios en blanco
        move_uploaded_file($tmp_name, $ruta_portada);

        // Insertar la ruta de la imagen en la base de datos
        $sql = "INSERT INTO libros (nombre, descripcion, fecha_publicacion, id_autor, stock, img_portada) VALUES ('$nombre','$descripcion','$fecha_publicacion','$id_autor','$stock','$ruta_portada')";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    } else {
        die("Error al subir la imagen. Asegúrate de que seleccionaste un archivo válido. " . mysqli_error($conn));
    }
} 

$sql = "SELECT LAST_INSERT_ID() as ultimo_id;"; //se obtiene el ultimo id de libro insertado para agregar los generos **!cambiar!**
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$ultimo_libro = mysqli_fetch_assoc($result);
$id_libro = $ultimo_libro['ultimo_id'];
foreach ($generos as $id_genero) {
    $sql = "INSERT INTO libros_generos (id_libro, id_genero) VALUES ($id_libro, $id_genero)";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  }
  mysqli_close($conn);
    header('Location: notificacion_resultado_libro.php?mensaje=exito');
    exit();

//header('Location: ruta')
?>