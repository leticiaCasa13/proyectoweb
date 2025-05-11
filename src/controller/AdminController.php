<?php
namespace controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use src\Database; // asegurarse de importar correctamente
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
        $this->db= Database::getInstance($config)->getConnection();
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
        echo "Entramos a dashboard()<br>";
        echo $this->twig->render('dashboard.html.twig', [
            'titulo' => 'Panel de Administración',
        ]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $stmt = $this->db->prepare("SELECT * FROM User WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin_logged_in'] = true;
                header("Location: /admin/dashboard");
                exit;
            } else {
                echo "<p style='color:red;'>Usuario o contraseña incorrectos</p>";
            }
        }

        // Mostrar formulario
        echo <<<HTML
        <h2>Login Administrador</h2>
        <form method="post">
            <label for="username">Usuario:</label><br>
            <input type="text" name="username" id="username" required><br><br>

            <label for="password">Contraseña:</label><br>
            <input type="password" name="password" id="password" required><br><br>

            <button type="submit">Ingresar</button>
        </form>
        HTML;
    }
}
