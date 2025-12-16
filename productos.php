<?php
header('Content-Type: application/json');

$archivo = 'productos.json';
$metodo = $_SERVER['REQUEST_METHOD'];

$productos = json_decode(file_get_contents($archivo), true);

// Validar que $productos sea un array
if (!is_array($productos)) {
    $productos = [];
}

// Ver todos los productos
if ($metodo === 'GET') {
    echo json_encode($productos);
    exit;
}

// Crear un producto
if ($metodo === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['nombre']) || !isset($data['precio'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan campos por llenar']);
        exit;
    }

    $nuevoId = count($productos) > 0 ? max(array_column($productos, 'id')) + 1 : 1;

    $nuevoproducto = [
        'id' => $nuevoId,
        'nombre' => $data['nombre'],
        'precio' => $data['precio']
    ];

    $productos[] = $nuevoproducto;
    file_put_contents($archivo, json_encode($productos, JSON_PRETTY_PRINT));

    echo json_encode(['mensaje' => 'Producto creado correctamente']);
    exit;
}

// Actualizar un producto
if ($metodo === 'PUT') {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID requerido']);
        exit;
    }

    $id = (int) $_GET['id'];
    $data = json_decode(file_get_contents("php://input"), true);

    foreach ($productos as &$producto) {
        if ($producto['id'] === $id) {
            $producto['nombre'] = $data['nombre'] ?? $producto['nombre'];
            $producto['precio'] = $data['precio'] ?? $producto['precio'];

            file_put_contents($archivo, json_encode($productos, JSON_PRETTY_PRINT));
            echo json_encode(['mensaje' => 'Producto actualizado correctamente']);
            exit;
        }
    }

    http_response_code(404);
    echo json_encode(['error' => 'Producto no encontrado']);
    exit;
}

//  Eliminar un producto
if ($metodo === 'DELETE') {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID no reconocido']);
        exit;
    }

    $id = (int) $_GET['id'];
    $nuevosProductos = array_filter($productos, fn($p) => $p['id'] !== $id);

    if (count($productos) === count($nuevosProductos)) {
        http_response_code(404);
        echo json_encode(['error' => 'Producto no encontrado']);
        exit;
    }

    file_put_contents($archivo, json_encode(array_values($nuevosProductos), JSON_PRETTY_PRINT));
    echo json_encode(['mensaje' => 'Producto eliminado correctamente']);
    exit;
}

// Método no permitido
http_response_code(405);
echo json_encode(['error' => 'Método no permitido']);
?>
