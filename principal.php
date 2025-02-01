<?php
session_start(); // Iniciar la sesión en la página protegida

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Si no está autenticado, redirigir a la página de login
    header("Location: Login-Template-3.html");
    exit();
}

// Si el usuario está autenticado, mostrar el contenido de la página
echo "Bienvenido, " . $_SESSION['usuario'] . "!";
// Resto del código para la página principal...
?>