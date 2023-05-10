<?php
$conn = mysqli_connect('localhost', 'root', '', 'db_gestor_bibliotecas');
if (!$conn) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
//ucword coloca cada palabra en cada espacio en mayuscula, preg_replace es para eliminar mas de un espacio en la cadena, 
//trim para quitar todos los espacios al final y al inicio de la cadena  
$nombre = ucwords(preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['nombre']))));
$apellido1 = ucwords(preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['apellido1']))));
$apellido2 = ucwords(preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['apellido2']))));
$cedula = str_replace(' ', '', mysqli_real_escape_string($conn, $_POST['cc']));
$correo = preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['correo'])));
$pass = preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['contra'])));

$sql = "INSERT INTO usuarios (cedula, nombre, apellido_1, apellido_2, correo, passw) 
        VALUES ('$cedula','$nombre', '$apellido1', '$apellido2', '$correo', '$pass')";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if($result){
    echo "se registro el usuario";
}else{
    echo "hubo un error al registrar el usuario";
}

?>