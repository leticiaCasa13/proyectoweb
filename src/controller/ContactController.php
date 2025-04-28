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
                // validar que el nombre solo contenga letras y espacios
                if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $name)) {
                    $_SESSION['flash_error'] = _("El nombre solo puede contener letras y espacios.");
                    $_SESSION['form_data'] = $_POST;
                }
            
                //validar email con el filtro php
                elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['flash_error'] = _("El correo electrónico no es válido.");
                    $_SESSION['form_data'] = $_POST;
                }
                // validar que el mensaje tenga 10 caracteres
                elseif (strlen($message) < 10) {
                    $_SESSION['flash_error'] = _("El mensaje debe tener al menos 10 caracteres.");
                    $_SESSION['form_data'] = $_POST;
                }
                //si todo está bien:
                
                else {
                    $_SESSION['flash_message'] = _("¡Tu mensaje ha sido enviado con éxito! En breve recibirás respuesta. ¡Gracias por contactarnos!");
                    unset($_SESSION['form_data']);
                }
        
            } else {
                // ❌ Error: campos vacíos
                $_SESSION['flash_error'] = _("¡Oops! Todos los campos son obligatorios.");
                $_SESSION['form_data'] = $_POST; // Guardar datos para rellenar el formulario
            }

            // Redirigir para evitar reenviar el formulario al recargar
            header('Location: /contact');
            exit;
        }

        // Si es GET: mostrar formulario
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
        $twig = new \Twig\Environment($loader);

        // Preparar datos para la vista
        $data = [
            'flash_message' => $_SESSION['flash_message'] ?? null,
            'flash_error' => $_SESSION['flash_error'] ?? null,
            'form_data' => $_SESSION['form_data'] ?? []
        ];

        // Limpiar mensajes de sesión después de leerlos
        unset($_SESSION['flash_message'], $_SESSION['flash_error'], $_SESSION['form_data']);

        // Renderizar plantilla de contacto
        echo $twig->render('contact.html.twig', $data);
    }
}

