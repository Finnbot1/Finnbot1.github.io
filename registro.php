<!-- registro.php -->
<?php
require 'conexionbase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cambia las claves para que coincidan con los atributos del formulario HTML
    $nombre_completo = $_POST['fullname']; // 'fullname' proviene del formulario HTML
    $correo_electronico = $_POST['email']; // 'email' proviene del formulario HTML
    $usuario = $_POST['username']; // 'username' proviene del formulario HTML
    $contrasena = password_hash($_POST['password'], PASSWORD_DEFAULT);// 'password' proviene del formulario HTML
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    // Cambia los nombres de las columnas en la consulta para que coincidan con la base de datos
    $stmt = $conn->prepare('INSERT INTO usuarios (nombre_completo, correo_electronico, usuario, contrasena, telefono, direccion) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssss', $nombre_completo, $correo_electronico, $usuario, $contrasena, $telefono, $direccion);

    if ($stmt->execute()) {
        echo 'Cuenta creada exitosamente';
        header('Location: Login-Template-2.html'); // Redirige al formulario de inicio de sesión
        exit;
    } else {
        echo 'Error al registrar usuario: ' . $stmt->error; // Muestra un mensaje de error detallado
    }
}
?>