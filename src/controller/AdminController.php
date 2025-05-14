<?php
namespace controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use src\Database;
use PDO;

if (!class_exists('src\Database')) {
    require_once __DIR__ . '/../Database.php';
}

class AdminController
{
    private $twig;
    private $db;

    public function __construct($config)
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates/admin');
        $this->twig = new Environment($loader);

        // Inicializar conexión a la base de datos
        $this->db = Database::getInstance($config)->getConnection();
    }

    public function listarPlantas()
    {
        echo "Aquí se mostrarán las plantas (aún sin implementar).";
    }

    public function listarCategorias()
    {
        echo "Aquí se mostrarán las categorías (aún sin implementar).";
    }

    public function dashboard()
    {
        // Consulta para obtener cantidad de plantas por categoría
        $stmt = $this->db->prepare("
            SELECT c.nombre AS categoria, COUNT(p.id) AS cantidad
            FROM Categoria c
            LEFT JOIN Planta p ON c.id = p.categoria_id
            GROUP BY c.nombre
        ");
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Separar nombres y cantidades para el gráfico
        $categorias = [];
        $cantidades = [];

        foreach ($resultados as $fila) {
            $categorias[] = $fila['categoria'];
            $cantidades[] = $fila['cantidad'];
        }

        // Renderizar vista al final, con los datos listos
         echo $this->twig->render('dashboard.html.twig', [
         'titulo' => 'Panel de Administración',
         'categorias' => $categorias,    // <-- Sin json_encode
         'cantidades' => $cantidades     // <-- Sin json_encode
        ]);

    }

    public function login()
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $stmt = $this->db->prepare("SELECT * FROM User WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                if ($user['role'] !== 'admin') {
                    // Contraseña correcta pero no es admin
                    $error = "Acceso denegado: no tienes permisos de Administrador.";
                } else {
                    // Guardar datos del usuario en la sesión
                    $_SESSION['user'] = [
                        'id'       => $user['id'],
                        'username' => $user['username'],
                        'role'     => $user['role'],
                    ];
                    header("Location: /admin/dashboard");
                    exit;
                }
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        }

        // Mostrar siempre el formulario (con o sin error)
        echo $this->twig->render('loginAdmin.html.twig', [
            'titulo' => 'Login Administrador',
            'error'  => $error
        ]);
    }
}
