<?php
include 'Conexion.php';
$conn = new Connection();
$codigo = $_POST['ingresar_codigo'];

$sql = "SELECT * FROM users WHERE codigo = ?";
$stmt = $conn->getConnection()->prepare($sql);
$stmt->bind_param("i", $codigo);  // "i" porque el código es un número entero

if ($stmt->execute()) {
    $result = $stmt->get_result();  // Obtenemos el resultado de la consulta
    $user = $result->fetch_assoc();

    if ($user) {
        // Actualizamos el campo 'verificado' a 1
        $sql = "UPDATE users SET verificado = 1 WHERE codigo = ?";
        $stmt = $conn->getConnection()->prepare($sql);
        $stmt->bind_param("i", $codigo);

        if ($stmt->execute()) {
            echo "<script>location.href='index.php'</script>";
        } else {
            echo "Error al verificar la cuenta.";
        }
    } else {
        echo "Código incorrecto.";
    }
} else {
    echo "Error al verificar la cuenta.";
}

$stmt->close();