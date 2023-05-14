<?php
require_once('../conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();
mysqli_set_charset($conn,'utf8mb4');

$id_libro = $_POST['id_libro'];
$sql = "SELECT * FROM libros
        INNER JOIN autores ON libros.id_autor = autores.id_autor
        WHERE id_libro = $id_libro";
$result = $proc->ejecutar_qury($conn, $sql);
$fila = mysqli_fetch_array($result);
$ruta_archivo = '../'.$fila['img_portada']; // ruta del archivo obtenida de la consulta
echo "
<html>

<head>
    <meta charset='UTF-8'>
    <title>Editar datos de libro</title>
    <link rel='stylesheet' type='text/css' href='../complementos/estilo.css'>
    <script src='../script.js'></script>
</head>

<body>
    <form action='admin_editar_libro_insertar.php' method='post' enctype='multipart/form-data'>
        <input type='hidden' name='id_libro' value='$id_libro'>
        <label class='labe' for='nombre'>Nombre</label>
        <input class='labe' type='text' name='nombre' value = '".$fila['nombre']."' required>
        <label class='labe' for='desc'>Descripcion</label>
        <input class='labe' type='text' name='desc' value = '".$fila['descripcion']."' required>
        <label class='labe' for='autor'>Autor</label>
        <input class='labe' type='text' name='autor' value = '".$fila['nombre_autor']."' required>
        <label class='labe' for='stock'>Stock</label>
        <input class='labe' type='number' name='stock' value = '".$fila['stock']."' required><br>
        <label class='checkbx'>Seleccione uno o varios geneross:</label>
        <div class='contenedor_checkbox'>";
        
            $sql = "SELECT g.nombre_genero FROM generos g
                    INNER JOIN libros_generos lg ON g.id_genero = lg.id_genero
                    WHERE lg.id_libro = $id_libro";
            $result_generos = $proc->ejecutar_qury($conn, $sql);
            $generos_libro = array(); // array para almacenar los nombres de los géneros que tiene el libro
            while ($row = mysqli_fetch_assoc($result_generos)) {
                $generos_libro[] = $row['nombre_genero'];
            }
            $sql_generos = 'SELECT * FROM generos';
            $result_generos = $proc->ejecutar_qury($conn, $sql_generos);
            $i = 0;
            while ($row_generos = mysqli_fetch_assoc($result_generos)) {
                if ($i % 5 == 0) {
                    echo "<div class='columna_chck'>";
                }
                $checked = (count(array_intersect($generos_libro, array($row_generos['nombre_genero']))) > 0) ? "checked" : "";
                echo "<div><label style='cursor: pointer'><input class='checkbox' type='checkbox' name='generos[]' value='" . $row_generos['id_genero'] . "' $checked>" . $row_generos['nombre_genero'] . "</label></div>";
                $i++;
                if ($i % 5 == 0) {
                    echo "</div>";
                }
            }
          echo "
      </div>
        <label class='labe' for='nombre'>Portada</label>
        <input class='labe' type='file' name='imagen' id='imagen' accept='image/*'>
        <button class='labe' type='submit' class='btn btn-primary'>Aceptar cambios</button>
    </form>
    <img style='width: 100px;' id='vista-previa' src='$ruta_archivo' alt='Vista previa de imagen''>
    
</body>
</html>";
?>