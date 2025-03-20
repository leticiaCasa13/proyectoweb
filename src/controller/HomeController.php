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
            $stmt = $this->db->query("SELECT * FROM categorias");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
        
            return [];
        }
    }

    public function mostrarCategoria($id)
    {
        $sql = "SELECT * FROM plantas WHERE categoria_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $plantas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>🔍 Datos enviados a Twig:</h3>";
        echo "<pre>";
        var_dump($plantas);
        echo "</pre>";

        // Renderizar la plantilla con Twig
        echo $this->twig->render('categoria.html.twig', [
            'title' => 'Categoría',
            'categoria' => ['id' => $id],
            'plantas' => $plantas
        ]);
    }
}
