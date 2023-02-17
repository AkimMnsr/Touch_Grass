<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoredController extends AbstractController
{
    #[Route('/bored', name: 'bored_bored')]
    public function index(): Response
    {
        return $this->render('bored/index.html.twig');
    }
}
