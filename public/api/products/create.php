<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

use App\Config\Database;
use App\Middleware\AuthMiddleware;

AuthMiddleware::user();

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
    $name === '' ||
    !is_numeric($price) ||
    !is_numeric($stock) ||
    $price < 0 ||
    $stock < 0
) {
    http_response_code(422);

    echo json_encode([
        'message' =>
            'Informe nome, preço e estoque válidos.'
    ]);

    exit;
}

$db = Database::connect();

$stmt = $db->prepare(
    'INSERT INTO products
        (
            name,
            description,
            price,
            stock
        )
     VALUES
        (
            :name,
            :description,
            :price,
            :stock
        )
     RETURNING
        id,
        name,
        description,
        price,
        stock'
);

$stmt->execute([
    'name' =>
        $name,

    'description' =>
        $description,

    'price' =>
        $price,

    'stock' =>
        (int)$stock,
]);

http_response_code(201);

echo json_encode([
    'message' =>
        'Produto criado com sucesso.',

    'product' =>
        $stmt->fetch(),
]);