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
    $ruta_proceso_usuario_and_listado_libros = '../notificacion_resultado_error.php';
    $ruta_default = 'notificacion_resultado_error.php';
    $ruta_administrador_prestamos = '../../notificacion_resultado_error.php';
    $ruta_administrador_entrega_libro = '../../../notificacion_resultado_error.php';
    
    if (file_exists($ruta_proceso_usuario_and_listado_libros)) {
      $ruta = $ruta_proceso_usuario_and_listado_libros;
    }else if(file_exists($ruta_administrador_prestamos)) {
      $ruta = $ruta_administrador_prestamos;
    }else if(file_exists($ruta_administrador_entrega_libro)) {
      $ruta = $ruta_administrador_entrega_libro;
    }else {
      $ruta = $ruta_default;
    }

    

    
    $result = mysqli_query($conn, $sentencia) or die(header('Location: '.$ruta.'?mensaje= Error al ejecutar proceso. '.mysqli_error($conn)));
    return $result;
  }
}
?>