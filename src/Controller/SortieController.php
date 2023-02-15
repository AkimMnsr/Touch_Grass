<?php

namespace App\Controller;

use App\Entity\Inscriptions;
use App\Entity\Sorties;
use App\Repository\InscriptionsRepository;
use App\Repository\SortiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{

    // Function Adding 'sortie'
    #[IsGranted('ROLE_USER')]
    #[Route('/addSortie', name: 'addSortie')]
    public function addSortie() : Response
    {

        return $this->render('sortie/addSortie.html.twig');

    }


    // Function show details of single 'sortie'
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}', name: 'sortie')]
    public function sortie(
        int $id,
        SortiesRepository $sortiesRepository
    ): Response
    {
        $sortie = $sortiesRepository->findOneBy(["id" =>$id]);
        return $this->render('sortie/sortie.html.twig',
            compact('sortie')
        );
    }



}

