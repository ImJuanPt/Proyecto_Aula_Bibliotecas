<html>

<head>
    <meta charset="UTF-8">
    <title>Insertar libro</title>
    <link rel="stylesheet" type="text/css" href="complementos/estilo.css">
    <script src="complementos/script.js"></script>
</head>

<body>
    <form action="insertar_libro.php" method="post" enctype="multipart/form-data">
        <label class="labe" for="nombre">Nombre</label>
        <input class="labe" type="text" name="nombre" required>
        <label class="labe" for="desc">Descripcion</label>
        <input class="labe" type="text" name="desc" required>
        <label class="labe" for="autor">Autor</label>
        <input class="labe" type="text" name="autor" required>
        <label class="labe" for="stock">Stock</label>
        <input class="labe" type="number" name="stock" required><br>
        <label class="checkbx">Seleccione uno o varios geneross:</label>
        <div class="contenedor_checkbox">
        <?php
          $conn = mysqli_connect('localhost', 'root', '', 'db_gestor_bibliotecas');
          mysqli_set_charset($conn,"utf8mb4");
          if (!$conn) {
            die("Error al conectar a la base de datos: " . mysqli_connect_error());
          } else {
            $sql = "SELECT * FROM generos";
            $result = mysqli_query($conn, $sql);
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              if ($i % 5 == 0) {
                echo "<div class='columna_chck'>";
              }
              echo "<div><label style = 'cursor: pointer'><input class='checkbox' type='checkbox' name='generos[]' value='".$row["id_genero"]."'>".$row["nombre_genero"]."</label></div>";
              $i++;
              if ($i % 5 == 0) {
                echo "</div>";
              }
            }
          }
        ?>
      </div>
        <label class="labe" for="nombre">Portada</label>
        <input class="labe" type="file" name="imagen" id="imagen" accept="image/*" required>
        <button class="labe" type="submit" class="btn btn-primary">
            Registrar libro
        </button>
    </form>
    <img class="" id="vista-previa" src="#" alt="Vista previa de imagen" style="display: none; width: 100px;">

</body>

</html>