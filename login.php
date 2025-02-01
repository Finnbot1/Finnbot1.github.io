<?php
// Conexión a la base de datos
require 'conexionbase.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar la variable de error
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['username'];
    $contrasena = $_POST['password'];

    // Consulta preparada para evitar inyecciones SQL
    $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verificar contraseña
        if (password_verify($contrasena, $hashed_password)) {
            // Redirigir al inicio
            session_start();
            $_SESSION['username'] = $usuario;
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit();
        } else {
            // Contraseña incorrecta, redirigir a la página de login
            header('Content-Type: application/json');
            echo json_encode(['success' => false]);
            exit();
        }
    } else {
        // Usuario no encontrado, redirigir a la página de login
        echo json_encode(['success' => false]);
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
