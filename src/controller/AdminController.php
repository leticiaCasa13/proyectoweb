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

        $this->db = Database::getInstance($config)->getConnection();
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

        $categorias = [];
        $cantidades = [];

        foreach ($resultados as $fila) {
            $categorias[] = $fila['categoria'];
            $cantidades[] = $fila['cantidad'];
        }

        echo $this->twig->render('dashboard.html.twig', [
            'titulo' => 'Panel de Administración',
            'categorias' => $categorias,
            'cantidades' => $cantidades
        ]);
    }

     public function listarPlantas()
   {
     // Consulta real a la tabla 'plantas'
     $stmt = $this->db->prepare("SELECT id, nombre, descripcion, precio, imagen_url, categoria_id FROM plantas");
     $stmt->execute();
     $plantas = $stmt->fetchAll(PDO::FETCH_ASSOC);

     echo $this->twig->render('adplantas.html.twig', [
        'titulo' => 'Gestión de Plantas',
        'plantas' => $plantas
    ]);
   }

 



    public function listarCategorias()
   {
     // Consulta real a la tabla 'categorias'
     $stmt = $this->db->prepare("SELECT id, nombre FROM categorias");
     $stmt->execute();
     $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

     echo $this->twig->render('adcategorias.html.twig', [
        'titulo' => 'Gestión de Categorías',
        'categorias' => $categorias
     ]);
   }


   public function formularioCrearPlanta()
{
    // Obtén las categorías para el selector
    $stmt = $this->db->query("SELECT id, nombre FROM categorias");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo $this->twig->render('formPlanta.html.twig', [
        'titulo' => 'Nueva Planta',
        'categorias' => $categorias
    ]);
}


    public function crearPlanta()
  {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    if (!empty($_FILES['imagen_file']['name'])) {
    $target_dir = __DIR__ . "/../../public/assets/images/";
    $image_name = uniqid() . '-' . basename($_FILES["imagen_file"]["name"]);
    move_uploaded_file($_FILES["imagen_file"]["tmp_name"], $target_dir . $image_name);
    $imagen_url = $image_name;

    } else {
    $imagen_url = $_POST['imagen_url'] ?? null;
    }

    $categoria_id = $_POST['categoria_id'];

    $stmt = $this->db->prepare("INSERT INTO plantas (nombre, descripcion, precio, imagen_url, categoria_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $precio, $imagen_url, $categoria_id]);

    header('Location: /admin/adplantas');
  }


  public function formularioEditarPlanta($id)
{
    $stmt = $this->db->prepare("SELECT * FROM plantas WHERE id = ?");
    $stmt->execute([$id]);
    $planta = $stmt->fetch(PDO::FETCH_ASSOC);

    $categorias = $this->db->query("SELECT id, nombre FROM categorias")->fetchAll(PDO::FETCH_ASSOC);

    echo $this->twig->render('formPlanta.html.twig', [
        'titulo' => 'Editar Planta',
        'planta' => $planta,
        'categorias' => $categorias
    ]);
 }

 public function actualizarPlanta($id)
{
    // Validar que los datos necesarios estén en $_POST
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $categoria_id = $_POST['categoria_id'] ?? null;

    // Manejo de la imagen (opcional)
    if (!empty($_FILES['imagen_file']['name'])) {
        $target_dir = __DIR__ . "/../../public/assets/images/";
        $image_name = uniqid() . '-' . basename($_FILES["imagen_file"]["name"]);
        move_uploaded_file($_FILES["imagen_file"]["tmp_name"], $target_dir . $image_name);
        $imagen_url = $image_name;
    } else {
        // Si no se sube una imagen nueva, mantener la actual (que viene en un campo oculto o similar)
        $imagen_url = $_POST['imagen_url'] ?? null;
    }

    // Actualizar en la base de datos
    $stmt = $this->db->prepare(
        "UPDATE plantas SET nombre = ?, descripcion = ?, precio = ?, imagen_url = ?, categoria_id = ? WHERE id = ?"
    );
    $stmt->execute([$nombre, $descripcion, $precio, $imagen_url, $categoria_id, $id]);

    // Redirigir después de actualizar
    header('Location: /admin/adplantas');
    exit;
}


    public function eliminarPlanta($id)
 {
    $stmt = $this->db->prepare("DELETE FROM plantas WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: /admin/adplantas');
 }

     public function getPlantasData()
   {
    // Consulta para obtener datos de plantas para el bubble chart
    $stmt = $this->db->prepare("
        SELECT 
            p.nombre,
            c.nombre AS categoria,
            p.precio AS valor1,           -- Eje X: Precio
            p.id AS valor2,               -- Eje Y: Podrías usar 'stock' si lo tuvieras
            LENGTH(p.descripcion) AS tamaño  -- Tamaño: longitud de la descripción (ajustado)
        FROM plantas p
        JOIN categorias c ON p.categoria_id = c.id
    ");

    $stmt->execute();
    $plantas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json");
    echo json_encode($plantas);
    exit;
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
                    $error = "Acceso denegado: no tienes permisos de Administrador.";
                } else {
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

        echo $this->twig->render('loginAdmin.html.twig', [
            'titulo' => 'Login Administrador',
            'error'  => $error
        ]);
    }


    public function logout()
  {
    // Iniciar sesión si no está iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Destruir todas las variables de sesión
    $_SESSION = [];

    // Destruir la sesión
    session_destroy();

    // Redirigir al login del admin
    header('Location: /loginAdmin');
    exit;
   
  }
}
