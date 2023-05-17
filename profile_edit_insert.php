<?php
require_once('conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();
$cc_usuario_sesion = mysqli_real_escape_string($conn, $_POST['cc_usuario_sesion']);
$nombre = ucwords(preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['nombre']))));
$apellido1 = ucwords(preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['apellido1']))));
$apellido2 = ucwords(preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['apellido2']))));
$cedula = str_replace(' ', '', mysqli_real_escape_string($conn, $_POST['cedula']));
$correo = preg_replace('/\s+/', ' ', trim(mysqli_real_escape_string($conn, $_POST['email'])));
$pass = mysqli_real_escape_string($conn, $_POST['contra']);

mysqli_set_charset($conn,"utf8mb4");


$sql = "UPDATE usuarios SET cedula = $cedula, nombre = '$nombre', apellido_1 = '$apellido1',
        apellido_2 = '$apellido2', passw = '$pass', correo = '$correo' WHERE cedula = $cc_usuario_sesion ";
$result = $proc->ejecutar_qury($conn, $sql);
echo '<script>alert("Los datos han sido actualizados con exito");</script>';
echo '<!DOCTYPE html>
<html>
<head>
  <title>Carga exitosa</title>
</head>
<body onload="volver()">
  <script>
  function volver() {
    window.history.back();
  }
  </script>
</body>
</html>'

?>