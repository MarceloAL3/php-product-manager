<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

use App\Config\Database;

$db = Database::connect();

$search =
    trim($_GET['search'] ?? '');

if ($search !== '') {

    $stmt = $db->prepare(
        'SELECT
            id,
            name,
            description,
            price,
            stock,
            created_at,
            updated_at
         FROM products
         WHERE name ILIKE :search
         ORDER BY id DESC'
    );

    $stmt->execute([
        'search' =>
            "%{$search}%"
    ]);

} else {

    $stmt = $db->query(
        'SELECT
            id,
            name,
            description,
            price,
            stock,
            created_at,
            updated_at
         FROM products
         ORDER BY id DESC'
    );
}

echo json_encode([
    'products' =>
        $stmt->fetchAll()
]);