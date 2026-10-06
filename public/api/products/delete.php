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

if (!$id) {

    http_response_code(422);

    echo json_encode([
        'message' =>
            'ID inválido.'
    ]);

    exit;
}

$db = Database::connect();

$stmt = $db->prepare(
    'DELETE FROM products
     WHERE id = :id'
);

$stmt->execute([
    'id' => $id
]);

if ($stmt->rowCount() === 0) {

    http_response_code(404);

    echo json_encode([
        'message' =>
            'Produto não encontrado.'
    ]);

    exit;
}

echo json_encode([
    'message' =>
        'Produto removido com sucesso.'
]);