<?php

namespace controller;

class GraficoController {
    private $twig;

    public function __construct($twig) {
        $this->twig = $twig;
    }

    public function mostrarGrafico() {
        echo $this->twig->render('graficoCategorias.html.twig', [
            'title' => 'Gráfico de Categorías',
        ]);
    }
}


