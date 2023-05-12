<?php
class proceso {
  public function conn() {
    $conn = mysqli_connect("localhost", "root", "", "db_gestor_bibliotecas");
    if (!$conn) {
        echo "Error No: " . mysqli_connect_errno();
        echo "Error Description: " . mysqli_connect_error();
        exit;
    }
    return $conn;
  }

  public function ejecutar_qury($conn,$sentencia){
    $result = mysqli_query($conn, $sentencia) or die(header('Location: ../notificacion_resultado_libro.php?mensaje= Error al ejecutar proceso. '.mysqli_error($conn)));
    return $result;
  }
}
?>