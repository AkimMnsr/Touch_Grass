<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Form\FiltreType;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(EntityManagerInterface $em,Request $request,SortiesRepository $sr): Response
    {
        $lesSorties=$sr->findAll();
        $date=new \DateTime();
        $filtreForm = $this->createForm(FiltreType::class);
        $filtreForm->handleRequest($request);
        /*if($filtreForm->isSubmitted()){

        }*/
        return $this->render('main/index.html.twig',
            compact('date','filtreForm','lesSorties')
        );
    }



}
