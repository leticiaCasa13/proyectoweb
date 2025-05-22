<?php

namespace controller;

class CartController {
    private $twig;
    private $config;

    public function __construct($twig) {      //inicializa la vista twig, carga de conexión a la bbdd
        $this->twig = $twig;
        $this->config = require __DIR__ . '/../../public/api/config/database.php';
    }

    //crea conexión PDO, con los datos (parámetros) de la bbdd

    private function getPDO() {
        $dsn = "mysql:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['database']};charset={$this->config['charset']}";
        return new \PDO($dsn, $this->config['username'], $this->config['password']);
    }
    
    //agrega planta, si existe suma la cantidad, 
    public function agregar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Método no permitido";
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $idPlanta = $_POST['id'] ?? null;
        $cantidad = isset($_POST['cantidad']) ? (int) $_POST['cantidad'] : 1;

        if (!$idPlanta) {
            echo "Falta el ID de la planta.";
            exit;
        }

        $conn = $this->getPDO();
        $stmt = $conn->prepare("SELECT nombre, precio, imagen_url FROM plantas WHERE id = ?");
        $stmt->execute([$idPlanta]);
        $planta = $stmt->fetch();

        if ($planta) {
            if (isset($_SESSION['carrito'][$idPlanta])) {
                $_SESSION['carrito'][$idPlanta]['cantidad'] += $cantidad;
            } else {
                $_SESSION['carrito'][$idPlanta] = [
                    'id' => $idPlanta,
                    'nombre' => $planta['nombre'],
                    'precio' => $planta['precio'],
                    'imagen_url' => $planta['imagen_url'],
                    'cantidad' => $cantidad,
                ];
            }
        }

        header("Location: /carrito");
        exit();
    }

    public function verPlanta($id) {
        $conn = $this->getPDO();
        $stmt = $conn->prepare("SELECT * FROM plantas WHERE id = ?");
        $stmt->execute([$id]);
        $planta = $stmt->fetch();

        echo $this->twig->render('plantaCarrito.html.twig', [
            'planta' => $planta
        ]);
    }

    public function mostrarCarrito() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $carrito = $_SESSION['carrito'] ?? [];

        $total = 0;
        foreach ($carrito as $planta) {
            $total += $planta['precio'] * $planta['cantidad'];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vaciar_carrito'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            unset($_SESSION['carrito']);
            // Refrescar sin redirigir fuera
            header("Location: /carrito");
            exit;
        }
        

        echo $this->twig->render('carritoComprar.html.twig', [
            'carrito' => $carrito,
            'total' => number_format($total, 2, ',', '.'),
            'title' => 'Carrito de Compras',
        ]);
    }

   public function procesarPago() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo "Método no permitido";
        exit;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Validación simple (esto se puede mejorar luego)
    $tarjeta = $_POST['tarjeta'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $vencimiento = $_POST['vencimiento'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    if (!$tarjeta || !$nombre || !$vencimiento || !$cvv) {
        // Redirigir al formulario de pago con mensaje de error
        header('Location: /finalizar-compra?error=1');
        exit;
    }

    // (Simulación de pago exitosa)
    // Limpiar carrito, registrar pedido, etc. Aquí pondrás tu lógica real
    $_SESSION['carrito'] = []; // Limpia el carrito, por ejemplo

    // Redirige a la página de confirmación
    header('Location: /gracias');
    exit;
}

    
    

    public function verCheckout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $carrito = $_SESSION['carrito'] ?? [];

        echo $this->twig->render('checkout.html.twig', [
            'carrito' => $carrito
        ]);
    }
}
