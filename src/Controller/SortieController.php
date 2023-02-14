<?php

namespace App\Controller;

use App\Entity\Inscriptions;
use App\Entity\Sorties;
use App\Repository\InscriptionsRepository;
use App\Repository\SortiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/sortie/{id}', name: 'sortie_sortie')]
    public function sortie(
        int $id,
        SortiesRepository $sortiesRepository,
        InscriptionsRepository $inscriptionsRepository
    ): Response
    {
        $sortie = $sortiesRepository->findOneBy(["id" =>$id]);
        return $this->render('sortie/sortie.html.twig',
            compact('sortie')
        );
    }
}
