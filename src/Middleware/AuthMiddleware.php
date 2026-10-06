<?php

namespace App\Middleware;

use App\Services\JwtService;
use Exception;

class AuthMiddleware
{
    public static function user(): object
    {
        $header =
            $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (
            !preg_match(
                '/Bearer\s+(.+)/i',
                $header,
                $matches
            )
        ) {
            http_response_code(401);

            echo json_encode([
                'message' => 'Token não informado.'
            ]);

            exit;
        }

        try {
            return JwtService::validate(
                $matches[1]
            );
        } catch (Exception $e) {
            http_response_code(401);

            echo json_encode([
                'message' =>
                    'Token inválido ou expirado.'
            ]);

            exit;
        }
    }
}