<?php
require 'conexionbase.php';
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Conexión fallida: " . $conn->connect_error]));
}

// Leer el cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $producto = $data['producto'];
    $cantidad = (int)$data['cantidad'];
    $precio = (float)$data['precio'];
    $total = $cantidad * $precio;

    // Insertar en la base de datos
    $sql = "INSERT INTO carrito (producto, cantidad, precio, total) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sidd", $producto, $cantidad, $precio, $total);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => "Compra realizada con éxito."]);
    } else {
        echo json_encode(['success' => false, 'message' => "Error al guardar el pedido: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => "Datos no válidos."]);
}

// Cerrar conexión
$conn->close();
?>