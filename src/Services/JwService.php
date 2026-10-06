<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    public static function create(
        int $userId,
        string $email
    ): string {
        $now = time();

        $expiration =
            $now + (int)($_ENV['JWT_EXPIRATION'] ?? 3600);

        $payload = [
            'iat' => $now,
            'exp' => $expiration,
            'sub' => $userId,
            'email' => $email,
        ];

        return JWT::encode(
            $payload,
            $_ENV['JWT_SECRET'],
            'HS256'
        );
    }

    public static function validate(
        string $token
    ): object {
        return JWT::decode(
            $token,
            new Key(
                $_ENV['JWT_SECRET'],
                'HS256'
            )
        );
    }
}