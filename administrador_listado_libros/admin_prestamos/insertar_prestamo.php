<?php
require_once('../../conexion_querys/conexion.php');
$proc = new proceso();
$conn = $proc->conn();

$id_libro = mysqli_real_escape_string($conn, $_POST['id_libro']);
$cc_usuario = mysqli_real_escape_string($conn, $_POST['cc_usuario']);

$sql = "SELECT * FROM usuarios WHERE cedula = $cc_usuario";
$result = $proc->ejecutar_qury($conn,$sql);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);
if($row['prestamos_activos'] < 5){ //maximo 5 prestamos puede tener el usuario, cuando llegue a 4 es menor que 5 e inserta el quinto y ultimo libro zzz
    if($row['puntaje'] >= 1){//puntaje minimo de 1 de 3
        $sql = "INSERT INTO prestamos (id_libro, cc_usuario) VALUES ($id_libro, $cc_usuario)";
        $result = $proc->ejecutar_qury($conn, $sql);
        $sql = "UPDATE usuarios SET prestamos_activos = (SELECT prestamos_activos WHERE cedula = $cc_usuario)+1 WHERE cedula = $cc_usuario";
        $result = $proc->ejecutar_qury($conn, $sql);

        echo "
        <html>
            <head>
             <title>Prestamo exitoso </title>
            </head>
            <body>
                <h5>El prestamo se registro con exito </h5>
                <form action='../admin_lista_libros.php' method='post'>
                <button type='submit'>Regresar</button>
                </form>
                
            </body>
        </html>
        ";
        
    }else{
        echo "el usuario ha sido penalizado por mal comportamiento, por tal motivo no se puede realizar el prestamo";
    }

}else{
    echo "el usuario alcanzo el limite de prestamos, por tal motivo no se puede realizar el prestamo";
}

?>