<?php
// Conexión a la base de datos
require 'conexionbase.php'; // Configura correctamente este archivo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y validar los valores del formulario
    $nombre = trim($_POST['name'] ?? '');
    $celular = trim($_POST['phone'] ?? '');
    $descripcion = trim($_POST['message'] ?? '');

    if ($nombre && $celular && $descripcion) {
        // Preparar la consulta
        $stmt = $conn->prepare("INSERT INTO contacto (nombre, celular, descripcion) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $celular, $descripcion);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>alert('Datos enviados correctamente.'); location.reload();</script>";
        } else {
            echo "<script>alert('Error al enviar los datos.');</script>";
        }

        // Cerrar la consulta y la conexión
        header("Location: ACERCA-DE-NOSOTROS.html");
        $stmt->close();
    } else {
        echo "<script>alert('Todos los campos son obligatorios.');</script>";
    }

    $conn->close();
}
?>
