<?php

namespace controller;

require_once 'BaseController.php';

class HomeController extends BaseController
{
    public function home()
    {
        $categorias = $this->getCategorias();

        echo $this->twig->render('home.html.twig', [
            'title' => _('Vivero Online'),
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
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function mostrarCategoria($id)
    {
        $sql_categoria = "SELECT nombre FROM categorias WHERE id = ?";
        $stmt_categoria = $this->db->prepare($sql_categoria);
        $stmt_categoria->execute([$id]);
        $categoria = $stmt_categoria->fetch(\PDO::FETCH_ASSOC);

        if (!$categoria) {
            $categoria['nombre'] = _("Categoría no encontrada");
        }

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
        $plantas = $stmt_plantas->fetchAll(\PDO::FETCH_ASSOC);

        $categoria['nombre'] = ucwords(strtolower($categoria['nombre']));

        echo $this->twig->render('categoria.html.twig', [
            'title' => $categoria['nombre'],
            'categoria' => $categoria,
            'plantas' => $plantas
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
        $plantas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo $this->twig->render('buscar.html.twig', [
            'plantas' => $plantas,
            'query' => $termino
        ]);
    }
}
