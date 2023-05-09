<?php
    $conn = mysqli_connect("localhost", "root", "", "db_gestor_bibliotecas");
    if (!$conn) {
        echo "Error No: " . mysqli_connect_errno();
        echo "Error Description: " . mysqli_connect_error();
        exit;
    }

    $sql = "SELECT *, autores.nombre_autor FROM libros 
            INNER JOIN autores ON libros.id_autor = autores.id_autor;";
    $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Elementos al lado</title>
        <link rel='stylesheet' type='text/css' href='complementos/estilo.css'>
        <script src='script.js'></script>
    </head>
        <body>
            <div class = 'consulta'>
                <form action='resultado_busqueda.php' method='post'>
                    <input type='text' name='texto_busqueda'>
                    <select name='opcion_busqueda'>
                        <option value='nombre'>Nombre</option>
                        <option value='nombre_autor'>Autor</option>
                        <option value='opcion3'>ISBN</option>
                    </select>
                    <button type='submit'>Buscar</button>
                </form>
            </div>

            <div class='contenedor'>";
            while($row = mysqli_fetch_array($result,MYSQLI_BOTH)){
             echo "<div class='elemento'>
                        <form id='form-libro-".$row['id_libro']."' action='descripcion_libro.php' method='POST'>
                            <input type='hidden' name='id_libro' value='".$row['id_libro']."'>
                            <center> <h4 style='cursor: pointer' onclick='submitForm(\"form-libro-".$row['id_libro']."\")'>" .
                                $row['nombre'] ."</h4>
                                <img src='".$row['img_portada']."' title='".$row['descripcion']."' style='width: 160px; height: 210px; cursor: pointer' onclick='submitForm(\"form-libro-".$row['id_libro']."\")'><br>
                                
                                Autor: <br>".$row['nombre_autor']." <br>
                                Stock: <br>". $row['stock']."
                            </center>
                        </form>
                    </div>";
            }
    
      echo "</div>
        </body>
    </html>";
?>