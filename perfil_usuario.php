<?php
session_start();
include('db.php'); // Archivo de conexión a la base de datos
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirigir si no está autenticado
    exit();
}
// Obtener información del usuario
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM usuarios WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="Login-Template-2.css">
</head>
<body>
    <section class="u-section-1">
        <div class="u-sheet-1">
            <div class="u-group-1">
                <div class="u-container-layout-1">
                    <div class="u-icon-1">
                        <!-- Puedes agregar un ícono de usuario aquí -->
                        👤
                    </div>
                    <h1 class="u-text-1">Perfil de Usuario</h1>
                    <div class="u-form-1">
                        <div class="u-label-1">
                            <strong>Bienvenido,</strong> 
                            <?php echo htmlspecialchars($user['nombre']); ?>
                        </div>
                        <div class="u-input-1">
                            <strong>Correo:</strong> 
                            <?php echo htmlspecialchars($user['email']); ?>
                        </div>
                        <div class="u-input-2">
                            <strong>Teléfono:</strong> 
                            <?php echo htmlspecialchars($user['telefono']); ?>
                        </div>
                        <div class="u-input-2">
                            <strong>Dirección:</strong> 
                            <?php echo htmlspecialchars($user['direccion']); ?>
                        </div>
                        <a href="logout.php" class="u-btn-1">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>