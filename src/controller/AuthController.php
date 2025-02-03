<?php

namespace controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PDO;

class AuthController {
    private $db;
    private $jwtSecret;

    public function __construct($config) {
        $this->jwtSecret = $config['jwt_secret'];
        try {
            $this->db = new PDO(
                "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}",
                $config['username'],
                $config['password']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public function authenticate($email, $password) {
        // Buscar usuario por email
        $stmt = $this->db->prepare("SELECT * FROM User WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'Usuario no encontrado'
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
        }
    }
}
