<!-- recover.php -->
<?php
require 'conexionbase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo_electronico = $_POST['email'];

    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE correo_electronico = ?');
    $stmt->bind_param('s', $correo_electronico);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "
            <script>
                alert('Se ha enviado un correo de recuperación.');
                setTimeout(function() {
                    window.location.href = 'recovercontraseña.html';
                }, 0); // 3000 milisegundos = 3 segundos
            </script>
        ";
    } else {
        echo "
            <script>
                alert('El correo no pertenece a ninguna cuenta, ingrese uno valido.');
                setTimeout(function() {
                    window.location.href = 'recovercontraseña.html';
                }, 0); // 3000 milisegundos = 3 segundos
            </script>
        ";
    }
}
?>