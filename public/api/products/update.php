<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

use App\Config\Database;
use App\Middleware\AuthMiddleware;

AuthMiddleware::user();

$id =
    filter_input(
        INPUT_GET,
        'id',
        FILTER_VALIDATE_INT
    );

$data =
    json_decode(
        file_get_contents('php://input'),
        true
    ) ?? [];

$name =
    trim($data['name'] ?? '');

$description =
    trim($data['description'] ?? '');

$price =
    $data['price'] ?? null;

$stock =
    $data['stock'] ?? null;

if (
    !$id ||
    $name === '' ||
    !is_numeric($price) ||
    !is_numeric($stock) ||
    $price < 0 ||
    $stock < 0
) {
    http_response_code(422);

    echo json_encode([
        'message' =>
            'Dados inválidos.'
    ]);

    exit;
}

$db = Database::connect();

$stmt = $db->prepare(
    'UPDATE products

     SET
        name = :name,
        description = :description,
        price = :price,
        stock = :stock,
        updated_at = CURRENT_TIMESTAMP

     WHERE id = :id

     RETURNING
        id,
        name,
        description,
        price,
        stock'
);

$stmt->execute([
    'id' =>
        $id,

    'name' =>
        $name,

    'description' =>
        $description,

    'price' =>
        $price,

    'stock' =>
        (int)$stock,
]);

$product =
    $stmt->fetch();

if (!$product) {

    http_response_code(404);

    echo json_encode([
        'message' =>
            'Produto não encontrado.'
    ]);

    exit;
}

echo json_encode([
    'message' =>
        'Produto atualizado com sucesso.',

    'product' =>
        $product,
]);