<?php
session_start();
require_once 'conexionbase.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: Login-Template-2.html');
    exit();
}

// Obtener información del usuario
$userId = $_SESSION['user_id'];
$user = getUserInfo($userId);
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Variables para enviar a la vista
$fullname = htmlspecialchars($user['nombre_completo']);
$email = htmlspecialchars($user['correo_electronico']);
$avatar = 'images/default-avatar.png'; // Ajusta el campo 'avatar_url' si existe en la tabla o utiliza una imagen predeterminada.

// Funciones de estadísticas
$totalOrders = getTotalOrders($userId);
$pendingOrders = getPendingOrders($userId);
$completedOrders = getCompletedOrders($userId);
?>