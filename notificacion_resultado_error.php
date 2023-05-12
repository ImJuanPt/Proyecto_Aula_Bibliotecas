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
          <title>Error en la pagina </title>
        </head>
        <body>
          <h4>Hubo un problema inesperado causado por: <b>'.$mensaje.' <b> <br></h4>
          <a href="procesos_usuario/inicio_sesion_usuario.html"><button>Regresar al login</button></a>
        </body>
      </html>';
    }
  }

?>