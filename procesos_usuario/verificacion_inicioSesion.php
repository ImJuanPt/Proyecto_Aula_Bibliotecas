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
    echo '
    <html>
        <body>
           ';

    if($row['passw'] === $pass){
        if($row['tipo_usuario'] === "DEFAULT"){
            echo"
            <form id='form-usuario' action='../listado_libros.php' method='POST'>";
        }else{
            echo"
            <form id='form-usuario' action='../administrador_listado_libros/admin_lista_libros' method='POST'>";
        }
    }else{
        echo "contraseña incorrecta";
    }
    echo '
                <input type="hidden" name="cc_usuario_sesion" value="'.$row['cedula'].'">
            </form>
        </body>

        <script>
            var form = document.getElementById("form-usuario");
            form.submit();
        </script>
    </html>';
}else{
    echo "la cedula que ingreso no se encuentra registrada";
}
?>