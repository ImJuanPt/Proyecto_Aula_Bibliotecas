require_once('../conexion_querys/conexion.php');
    $proc = new proceso();
    $conn = $proc->conn();
    mysqli_set_charset($conn,"utf8mb4");
    session_start();