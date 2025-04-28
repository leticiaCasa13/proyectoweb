<?php

namespace controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use src\Database; //asegurar q se importe la clase Database
use PDO;

if (!class_exists('src\Database')) {
    require __DIR__ . '/../Database.php';
}


class AuthController {
    private $db;
    private $jwtSecret;

    public function __construct($config) {
        $this->jwtSecret = $config['jwt_secret'];
       
        //usamos la clase Database en lugar de crear una nueva conexión
        $this->db = Database::getInstance($config)->getConnection();
    }

    public function authenticate($email, $password) {
           global $config;
           

        // Buscar usuario por email

        $stmt = $this->db->prepare("SELECT * FROM User WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                'status' => 'error',
                'message' => _("Usuario no encontrado")   

            ];
        }

        

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            

            // Generar token JWT
            $payload = [
                'id' => $user['id'],
                'email' => $user['email'],
                'username' => $user['username'],
                'iat' => time(),
                'exp' => time() + (60 * 60) // 1 hora
            ];
            $token = JWT::encode($payload, $this->jwtSecret, 'HS256');

            return [
                'status' => 'success',
                'message' => 'Inicio de sesión exitoso',
                'token' => $token
            ];
        } else {
        
            return [
                'status' => 'error',
                'message' => 'Credenciales incorrectas'
            ];
        }    //ahora AuthController usa la misma conexión de la bd que register.php
    }
}


