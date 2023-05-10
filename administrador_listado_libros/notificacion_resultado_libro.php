<?php
$mensaje = $_GET['mensaje'];
if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] == 'exito') {
      echo '
      <html>
        <head>
          <title>Libro registrado </title>
        </head>
        <body>
          <h4>Se registro correctamente el libro, que desea hacer acontinuacion</h4>
          <a href="admin_insertar_libro_principal.php"><button>Registrar otro libro</button></a>
          <a href="admin_lista_libros.php"><button>Lista de libros</button></a>
        </body>
      </html>';
    }else{
      echo '
      <html>
        <head>
          <title>Error al registrar </title>
        </head>
        <body>
          <h4>No se registro correctamente el libro, causado por: <b>'.$mensaje.' <b> <br> ¿Qué desea hacer a continuacion?</h4>
          <a href="admin_insertar_libro_principal.php"><button>Registrar otro libro</button></a>
          <a href="admin_lista_libros.php"><button>Lista de libros</button></a>
        </body>
      </html>';
    }
  }

?>