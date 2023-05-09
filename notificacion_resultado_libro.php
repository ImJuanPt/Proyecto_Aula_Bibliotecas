<?php
if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] == 'exito') {
      echo 'El bloque de código se ejecutó correctamente.';
    } else if ($_GET['mensaje'] == 'error') {
      echo 'Hubo un problema en la ejecución del bloque de código.';
    }
  }

?>