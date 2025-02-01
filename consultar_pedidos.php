<?php
// Incluir el archivo de conexión existente
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'conexionbase.php';  


 
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$message_error = 'No entro';

try {
    // Asumiendo que tu conexión está en una variable llamada $conexion o $conn
    // Modifica esto según el nombre de tu variable de conexión
    
    // Verificar si el usuario está logueado
    // if (!isset($_SESSION['usuario_id'])) {
	// $message_error = 'No inicio sesion';
    //     throw new Exception('Usuario no autenticado');
    // }

    // $usuario_id = $_SESSION['usuario_id'];

    // Consulta SQL para obtener los pedidos del usuario
    $sql = "SELECT  
                p.id AS numero_pedido, -- Se asume que 'numero_pedido' se refiere al campo 'id' de pedidos
                GROUP_CONCAT(pro.nombre SEPARATOR ', ') AS productos,
                SUM(dp.cantidad * dp.precio_unitario) AS costo_total, -- Cálculo explícito del costo total
                p.fecha_pedido,
                p.estado
            FROM pedidos p
            LEFT JOIN detalle_pedido dp ON p.id = dp.pedido_id
            LEFT JOIN productos pro ON dp.producto_id = pro.id 
            -- WHERE p.usuario_id = ? -- Filtro opcional para un usuario específico
            GROUP BY p.id, p.fecha_pedido, p.estado
            ORDER BY p.fecha_pedido DESC;
            ";

    $stmt = $conn->prepare($sql);

  // Usa $conexion o el nombre de tu variable
  // $stmt->bind_param("i", $usuario_id);
  $stmt->execute();
  $stmt->bind_result($numero_pedido, $productos, $costo_total, $fecha_pedido, $estado);
  $pedidos = array(); 

  while ($stmt->fetch()) {
      $fila = array(
          "numero_pedido" => $numero_pedido,
          "productos" => $productos,
          "costo" => number_format($costo_total, 2), // Formatear el costo
          "fecha" => date('d/m/Y', strtotime($fecha_pedido)),
          "estado" => $estado
      );
      // Agregar la fila al array de resultados
      array_push($pedidos, $fila);
  }
    /*
    $pedidos = array();
    
    while ($row = $resultado->fetch_assoc()) {
        $pedidos[] = array(
            'numero_pedido' => $row['numero_pedido'],
            'productos' => $row['productos'],
            'costo' => number_format($row['costo_total'], 2),
            'fecha' => date('d/m/Y', strtotime($row['fecha_pedido'])),
            'estado' => $row['estado']
        );
    }
*/ 
    // Devolver los resultados como JSON
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'pedidos' => $pedidos]);

} catch (Exception $e) {
    // En caso de error, devolver un mensaje de error
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $message_error ]);
}

// Cerrar la declaración preparada
if (isset($stmt)) {
    $stmt->close();
}

// No cerrar la conexión aquí si está siendo manejada por tu archivo de conexión
?>