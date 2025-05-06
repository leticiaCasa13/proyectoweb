<?php

namespace controller;

class ContactController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Si es POST: procesar formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $message = $_POST['message'] ?? '';
    
            if (!empty($name) && !empty($email) && !empty($message)) {
                if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $name)) {
                    $_SESSION['flash_error'] = _("El nombre solo puede contener letras y espacios.");
                    $_SESSION['form_data'] = $_POST;
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['flash_error'] = _("El correo electrónico no es válido.");
                    $_SESSION['form_data'] = $_POST;
                } elseif (strlen($message) < 10) {
                    $_SESSION['flash_error'] = _("El mensaje debe tener al menos 10 caracteres.");
                    $_SESSION['form_data'] = $_POST;
                } else {
                    $_SESSION['flash_message'] = _("¡Tu mensaje ha sido enviado con éxito! En breve recibirás respuesta. ¡Gracias por contactarnos!");
                    unset($_SESSION['form_data']);
                }
            } else {
                $_SESSION['flash_error'] = _("¡Oops! Todos los campos son obligatorios.");
                $_SESSION['form_data'] = $_POST;
            }
    
            header('Location: /contact');
            exit;
        }
    
        // Si es GET: mostrar formulario
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
        $twig = new \Twig\Environment($loader);
    
        $data = [
            'title' => 'Contacto', // esto te faltaba
            'flash_message' => $_SESSION['flash_message'] ?? null,
            'flash_error' => $_SESSION['flash_error'] ?? null,
            'form_data' => $_SESSION['form_data'] ?? [],
        ];
    
        unset($_SESSION['flash_message'], $_SESSION['flash_error'], $_SESSION['form_data']);
    
        echo $twig->render('contact.html.twig', $data);
    }
}

