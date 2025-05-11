<?php

namespace controller;

use PDO;
use PDOException;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class HomeController
{
    private $db;
    private $twig;

    public function __construct()
    {
        $config = require __DIR__ . '/../../public/api/config/database.php';

        try {
            $this->db = new PDO(
                "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}",
                $config['username'],
                $config['password']
            );

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "✅ Conexión exitosa a la base de datos.<br>";

        } catch (PDOException $e) {
            die("❌ Error de conexión a la BD: " . $e->getMessage());
        }

        // Configurar Twig una sola vez
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader, [
            'debug' => true,
            'cache' => false
        ]);
        $this->twig->addExtension(new DebugExtension());
    }

    public function home()
    {
        $categorias = $this->getCategorias();


        // Renderizar la plantilla con Twig
        echo $this->twig->render('home.html.twig', [
            'title' => 'Vivero Online',
            'categorias' => $categorias
        ]);
    }

    public function getCategorias()
    {
        try {
            $stmt = $this->db->query("
                SELECT id, nombre 
                FROM categorias 
                ORDER BY FIELD(nombre, 'PLANTAS ANUALES', 'PLANTAS PERENNES', 'ARBUSTOS', 'ÁRBOLES', 'DE INTERIOR')
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function mostrarCategoria($id)
   {
    // Obtener el nombre de la categoría
    $sql_categoria = "SELECT nombre FROM categorias WHERE id = ?";
    $stmt_categoria = $this->db->prepare($sql_categoria);
    $stmt_categoria->execute([$id]);
    $categoria = $stmt_categoria->fetch(PDO::FETCH_ASSOC);

    // Si no se encuentra la categoría, puedes manejarlo con un error o un valor por defecto
    if (!$categoria) {
        // Maneja el error o asigna un valor por defecto
        $categoria['nombre'] = _("Categoría no encontrada");
    }

    // Obtener las plantas de esa categoría
    $sql_plantas = "
        SELECT 
            p.id, 
            p.nombre, 
            p.descripcion, 
            p.precio, 
            COALESCE(i.imagen_url, 'https://via.placeholder.com/150') AS imagen_url
        FROM plantas p
        LEFT JOIN imagenes i ON p.id = i.planta_id
        WHERE p.categoria_id = ?
    ";

    $stmt_plantas = $this->db->prepare($sql_plantas);
    $stmt_plantas->execute([$id]);
    $plantas = $stmt_plantas->fetchAll(PDO::FETCH_ASSOC);


     // Convertir el nombre de la categoría a formato "Plantas Anuales"
     $categoria['nombre'] = ucwords(strtolower($categoria['nombre']));


     // Renderizar la plantilla con Twig 
    echo $this->twig->render('categoria.html.twig', [
        'title' => $categoria['nombre'], // Título de la categoría
        'categoria' => $categoria, // Datos de la categoría
        'plantas' => $plantas // Datos de las plantas 
    ]);
    
   }

   public function buscarPlantas()
{
    $termino = $_GET['q'] ?? '';

    if (empty($termino)) {
        echo $this->twig->render('buscar.html.twig', [
            'plantas' => [],
            'query' => $termino
        ]);
        return;
    }

    $sql = "
        SELECT 
            p.id, 
            p.nombre, 
            p.descripcion, 
            p.precio, 
            COALESCE(i.imagen_url, 'https://via.placeholder.com/150') AS imagen_url
        FROM plantas p
        LEFT JOIN imagenes i ON p.id = i.planta_id
        WHERE p.nombre LIKE ?
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['%' . $termino . '%']);
    $plantas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo $this->twig->render('buscar.html.twig', [
        'plantas' => $plantas,
        'query' => $termino
    ]);
}


}