<?php

namespace App\Controller;

use App\Service\Temperature;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TemperatureController extends AbstractController
{
    /**
     * @Route("/temperature", name="temperature")
     */
    public function index(Temperature $temperature)
    {
        $degrees = $temperature->getTemperature();

        return $this->render('temperature/index.html.twig', [
            'degrees' => $degrees,
        ]);
    }
}