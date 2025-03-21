<?php 

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route('/*', function() {
    if(
        strpos(Flight::request()->url, '/auth/login') === 0 || 
        strpos(Flight::request()->url, '/auth/register') === 0
        ) {
        return TRUE;
    } else {
        //throw new Exception("It works", 404);
        try {
            $token = Flight::request()->getHeader("Authentication");
            if(!$token)
                Flight::halt(401, "Missing authentication header");
    
            $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
    
            Flight::set('user', $decoded_token->user);
            Flight::set('jwt_token', $token);
    
            Flight::json([
                'jwt_decoded' => $decoded_token,
                'user' => $decoded_token->user
            ]);
            return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
});

Flight::map('error', function(Exception $e) {
    file_put_contents("logs.txt", $e . PHP_EOL, FILE_APPEND | LOCK_EX);

    Flight::halt($e->getCode(), $e->getMessage());
    Flight::stop($e->getCode());
});