<?php
include 'conexionbase.php';

// Consulta SQL para obtener los pedidos con su fecha
$sql = "SELECT 
    p.id_pedido,
    GROUP_CONCAT(pr.nombre_producto SEPARATOR ', ') as productos,
    p.estado_pedido,
    p.fecha_pedido
FROM pedidos p
LEFT JOIN detalle_pedido dp ON p.id_pedido = dp.id_pedido
LEFT JOIN productos pr ON dp.id_producto = pr.id_producto
GROUP BY p.id_pedido
ORDER BY p.fecha_pedido DESC
LIMIT 5"; // Limitamos a 5 pedidos más recientes

$resultado = mysqli_query($conexion, $sql);

$pedidos = array();

if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $pedidos[] = array(
            'pedido' => $fila['id_pedido'],
            'productos' => $fila['productos'],
            'estado' => $fila['estado_pedido'],
            'fecha' => date('d/m/Y', strtotime($fila['fecha_pedido']))
        );
    }
}

// Devolvemos los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($pedidos);

mysqli_close($conexion);
?>