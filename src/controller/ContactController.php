// src/Controller/ContactController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {
        // Comprobar si se envió el formulario
        if ($request->isMethod('POST')) {
            $name = $request->get('name');
            $email = $request->get('email');
            $message = $request->get('message');

            // Verificar si todos los campos fueron llenados
            if ($name && $email && $message) {
                // Aquí podrías agregar la lógica para enviar el mensaje a un correo o guardarlo

                // Guardar el mensaje de éxito en la sesión
                $this->addFlash('message', '¡Tu mensaje ha sido enviado con éxito!');

                // Redirigir a la misma página con el mensaje de éxito
                return $this->redirectToRoute('contact');
            } else {
                // Guardar el mensaje de error en la sesión
                $this->addFlash('error', '¡Oops! Todos los campos son obligatorios.');

                // Redirigir a la misma página con el mensaje de error
                return $this->redirectToRoute('contact');
            }
        }

        // Si no se envió el formulario, mostrar la página de contacto
        return $this->render('contact.html.twig', [
            'description' => 'Déjanos tu mensaje, ¡estaremos encantados de responderte!',
        ]);
    }
}
