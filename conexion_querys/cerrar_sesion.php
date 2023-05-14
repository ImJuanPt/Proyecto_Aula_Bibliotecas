<?php
require_once('conexion.php');
$proc = new proceso();
$conn = $proc->conn();
$cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);


$result = $proc->ejecutar_qury($conn, $proc->sql_cerrarSesion($cc_usuario_sesion));
if($result){
    session_start(); // Iniciar la sesión
    unset($_SESSION['logged_in']);
    header("Location: ../procesos_usuario/inicio_sesion_usuario.html");
}else{
    echo "hola";
}
?>