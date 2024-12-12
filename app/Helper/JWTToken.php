<?php
namespace App\Helper;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken{
     public static function createToken($userEmail){
        $key = env('JWT_KEY');
        $payLoad = [
            'iss' => 'Laravel-token',
            'iat' => time(),
            'exp' => time()+60*60,
            'userEmail' => $userEmail,
        ];
        $jwt = JWT::encode($payLoad, $key, 'HS256');
        return $jwt;
    }

    public static function createTokenForSetPassword ($userEmail)
    {
        $key = env('JWT_KEY');
        $payLoad = [
            'iss' => 'Laravel-token',
            'iat' => time(),
            'exp' => time()+60*10,
            'userEmail' => $userEmail,
        ];
        $jwt = JWT::encode($payLoad, $key, 'HS256');
        return $jwt;
    }

    public static function verifyToken($token) {
        try {
            $key = env('JWT_KEY');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded->userEmail;
        } catch (Exception $e) {
            return "Unauthorized";
        }
    }
}
