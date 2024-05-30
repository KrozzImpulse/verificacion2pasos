<?php
include 'Conexion.php';

$conn = new Connection();

$username = htmlspecialchars($_POST['username']);
$password = $_POST['password'];

// Preparar la consulta utilizando ? como marcador de posición
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->getConnection()->prepare($sql);
$stmt->bind_param("s", $username);  // "s" porque el username es una cadena

if ($stmt->execute()) {
    $result = $stmt->get_result();  // Obtener el resultado de la consulta
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        echo "Login successful!";
        // Aquí puedes iniciar la sesión del usuario, por ejemplo:
        session_start();
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Invalid username or password.";
    }
} else {
    echo "Error executing query.";
}

$stmt->close();