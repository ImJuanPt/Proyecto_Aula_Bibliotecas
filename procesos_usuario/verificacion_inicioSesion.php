<?php
require_once('../conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();

$cedula = str_replace(' ', '', mysqli_real_escape_string($conn, $_POST['cc'])); 
$pass = mysqli_real_escape_string($conn, $_POST['contra']);

$sql = "SELECT * FROM usuarios WHERE cedula = $cedula;";
$result = $proc->ejecutar_qury($conn, $sql);

$row = mysqli_fetch_array($result,MYSQLI_BOTH);
echo '
<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="container">
                <div class="container-login">
                    <div class="container-logo">

';
    if(mysqli_num_rows($result) != 0){
        if($row['passw'] == $pass){
            if($row['tipo_usuario'] === "DEFAULT"){
                echo"
                <form id='form-usuario' action='../index.php' method='POST'>";
            }else{
                echo"
                <form id='form-usuario' action='../administrador_listado_libros/admin_lista_libros' method='POST'>";
            }
        }else{
            echo '
            <div class="titulo">
                            <p>Libread</p>
                        </div>
                    <a href="index.html"><img src="Assets/Images/Logo/image-removebg-preview.png" alt=""></a> 
                    </div>
                        <div class="container-form">
                            <div class="register_camp">
                        <p>La contraseña es incorrecta para el usuario que intenta ingresar, intentelo de nuevo  </p>
                        <a href="inicio_sesion_usuario.html"><button type="button">Volver al inicio de sesion</button></a>
                        </div>
                    </div>
                </div>
            </div>';
            
        }
        echo '
                    <input type="hidden" name="cc_usuario_sesion" value="'.$row['cedula'].'">
                </form>';
    }else{
        echo '
                        <div class="titulo">
                            <p>Libread</p>
                        </div>
                    <a href="index.html"><img src="Assets/Images/Logo/image-removebg-preview.png" alt=""></a> 
                    </div>
                        <div class="container-form">
                            <div class="register_camp">';
        echo '<p>La cedula que intenta ingresar no se encuentra registrada, intentelo de nuevo </p>
        <a href="inicio_sesion_usuario.html"><button type="button">Volver al inicio de sesion</button></a>
                    </div>
                </div>
            </div>
        </div>';
    }
    echo "
    </body>
            <script>
                var form = document.getElementById('form-usuario');
                form.submit();
            </script>
        </html>";
?>