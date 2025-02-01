<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['usuario'])) {
    echo json_encode(["autenticado" => true, "nombre" => $_SESSION['nombre']]);
} else {
    echo json_encode(["autenticado" => false]);
}
?>