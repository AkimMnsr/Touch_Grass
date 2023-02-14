<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Repository\ParticipantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil', name: 'profil_profil')]
class ProfilController extends AbstractController
{
    #[Route('/', name: 'profil_afficher')]
    public function afficher(
    ): Response
    {
        return $this->render('profil/afficher.html.twig');
    }
}
