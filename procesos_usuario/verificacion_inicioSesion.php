<?php
$conn = mysqli_connect('localhost', 'root', '', 'db_gestor_bibliotecas');
if (!$conn) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

$cedula = str_replace(' ', '', mysqli_real_escape_string($conn, $_POST['cc']));
$pass = mysqli_real_escape_string($conn, $_POST['contra']);
$sql = "SELECT * FROM usuarios WHERE cedula = $cedula";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result,MYSQLI_BOTH);

if(mysqli_num_rows($result) > 0){
    if($row['passw'] === $pass){
        echo "iniciaste sesion  !!!GO TO XNXX.COM!!!";
    }else{
        echo "contraseña incorrecta";
    }
}else{
    echo "la cedula que ingreso no se encuentra registrada";
}
?>