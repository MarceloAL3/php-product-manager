<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

use App\Config\Database;

$data =
    json_decode(
        file_get_contents('php://input'),
        true
    ) ?? [];

$name =
    trim($data['name'] ?? '');

$email =
    strtolower(
        trim($data['email'] ?? '')
    );

$password =
    $data['password'] ?? '';

if (
    $name === '' ||
    !filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    ) ||
    strlen($password) < 6
) {
    http_response_code(422);

    echo json_encode([
        'message' =>
            'Nome, e-mail válido e senha com no mínimo 6 caracteres são obrigatórios.'
    ]);

    exit;
}

$db = Database::connect();

$check = $db->prepare(
    'SELECT id FROM users WHERE email = :email'
);

$check->execute([
    'email' => $email
]);

if ($check->fetch()) {
    http_response_code(409);

    echo json_encode([
        'message' => 'E-mail já cadastrado.'
    ]);

    exit;
}

$stmt = $db->prepare(
    'INSERT INTO users
        (name, email, password)
     VALUES
        (:name, :email, :password)
     RETURNING id'
);

$stmt->execute([
    'name' => $name,
    'email' => $email,
    'password' =>
        password_hash(
            $password,
            PASSWORD_DEFAULT
        ),
]);

http_response_code(201);

echo json_encode([
    'message' =>
        'Usuário cadastrado com sucesso.',

    'userId' =>
        $stmt->fetchColumn(),
]);