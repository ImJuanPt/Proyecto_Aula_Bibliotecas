<?php
require_once('../conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();

echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Login</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="container">
                <div class="container-login">
                    <div class="container-logo">
                        <div class="titulo">
                            <p>Libread</p>
                        </div>
                    <a href="index.html"><img src="Assets/Images/Logo/image-removebg-preview.png" alt=""></a> 
                    </div>
                        <div class="container-form">
                            <div class="register_camp">';

//ucword coloca cada palabra en cada espacio en mayuscula, preg_replace es para eliminar mas de un espacio en la cadena, 
//trim para quitar todos los espacios al final y al inicio de la cadena  
$nombre = ucwords(preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['nombre']))));
$apellido1 = ucwords(preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['apellido1']))));
$apellido2 = ucwords(preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['apellido2']))));
$cedula = str_replace(' ', '', mysqli_real_escape_string($conn, $_POST['cc']));
$correo = preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['correo'])));
$pass = mysqli_real_escape_string($conn, $_POST['contra']);

$sql = "SELECT * FROM usuarios WHERE cedula = '$cedula'";
$result = $proc->ejecutar_qury($conn, $sql);
if(mysqli_num_rows($result) === 0){
    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $result = $proc->ejecutar_qury($conn, $sql);
    if(mysqli_num_rows($result) === 0){
        $sql = "INSERT INTO usuarios (cedula, nombre, apellido_1, apellido_2, correo, passw) 
                VALUES ('$cedula','$nombre', '$apellido1', '$apellido2', '$correo', '$pass')";
        $result = $proc->ejecutar_qury($conn, $sql);
        if($result){
            echo '<p>Registro exitoso</p>
                    <a href="inicio_sesion_usuario.html"><button type="button">Volver al login</button></a>';
        }else{
            echo '<p>Hubo un problema con el registro, pronto solucionaremos los problemas </p>
            <a href="inicio_sesion_usuario.html"><button type="button">Volver a inicio de sesion</button></a>';
        }
    }else{
        echo '<p>Hubo un problema, el correo que intenta ingresar ya se encuentra registrado, inicie sesion o intente con otra correo </p>
        <a href="registrar_usuario.html"><button type="button">Volver al registro</button></a>';
    }
}else{
    echo '<p>Hubo un problema, la cedula que intenta ingresar ya se encuentra registrada, inicie sesion o intente con otra cedula </p>
            <a href="registrar_usuario.html"><button type="button">Volver al registro</button></a>
            ';
            
}
echo '              </div>
                </div>
        </div>
    </div>
</body>
</html>';
?>