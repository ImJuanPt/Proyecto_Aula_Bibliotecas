<?php
require_once('../conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();

$cedula = str_replace(' ', '', mysqli_real_escape_string($conn, $_POST['cc'])); 
$pass = mysqli_real_escape_string($conn, $_POST['contra']);

$sql = "SELECT * FROM usuarios WHERE cedula = $cedula;";
$result = $proc->ejecutar_qury($conn, $sql);

$row = mysqli_fetch_array($result,MYSQLI_BOTH);
    if(mysqli_num_rows($result) > 0){
        echo '
        <html>
            <body>
            ';
        if($row['passw'] == $pass){
            if($row['tipo_usuario'] === "DEFAULT"){
                echo"
                <form id='form-usuario' action='../index.php' method='POST'>";
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