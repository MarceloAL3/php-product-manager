<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

use App\Config\Database;
use App\Services\JwtService;

$data =
    json_decode(
        file_get_contents('php://input'),
        true
    ) ?? [];

$email =
    strtolower(
        trim($data['email'] ?? '')
    );

$password =
    $data['password'] ?? '';

if (
    !filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    ) ||
    $password === ''
) {
    http_response_code(422);

    echo json_encode([
        'message' =>
            'Informe e-mail e senha.'
    ]);

    exit;
}

$db = Database::connect();

$stmt = $db->prepare(
    'SELECT
        id,
        name,
        email,
        password
     FROM users
     WHERE email = :email'
);

$stmt->execute([
    'email' => $email
]);

$user = $stmt->fetch();

if (
    !$user ||
    !password_verify(
        $password,
        $user['password']
    )
) {
    http_response_code(401);

    echo json_encode([
        'message' =>
            'E-mail ou senha inválidos.'
    ]);

    exit;
}

$token =
    JwtService::create(
        (int)$user['id'],
        $user['email']
    );

echo json_encode([
    'message' =>
        'Login realizado com sucesso.',

    'token' => $token,

    'user' => [
        'id' =>
            (int)$user['id'],

        'name' =>
            $user['name'],

        'email' =>
            $user['email'],
    ],
]);