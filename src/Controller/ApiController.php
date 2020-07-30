<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/", name="api_index")
     */
    public function index()
    {
        $response = new JsonResponse();
        $response->setData([
            'data' => 'foo bar baz',
        ]);

        return $response;
    }
}
