<?php

namespace App\Controller;

use App\Form\FiltreType;
use App\Helper\ServiceUtilitaire;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(EntityManagerInterface $em,Request $request,SortiesRepository $sr,ServiceUtilitaire $su): Response
    {
        $date=new \DateTime();
        $reset=false;
        if($this->isGranted('ROL'))
        $lesSorties=$sr->findAll();

        $filtreForm = $this->createForm(FiltreType::class);
        $filtreForm->handleRequest($request);
        if($filtreForm->isSubmitted()){

            $reset=false;
            $lesSorties=[];

            $lieu=$request->get("filtre")['lieux_no_lieu'];
            $nom=$request->get("filtre")["nom"];
            $dateDeb=$request->get("filtre")['datedebut'];
            $dateFin=$request->get("filtre")['datecloture'];

            if($lieu!=null||$lieu!=""){
                $lesSorties+=$sr->findByLieu($lieu);
                $reset=true;
            }
            if($nom!=null||$nom!=""){
                $lesSorties+=$sr->findByNom($nom);
                $reset=true;
            }
            if($dateDeb!=null){
                $lesSorties+=$sr->findBy(['datedebut'=>$dateDeb]);
                $reset=true;
            }
            if($dateFin!=null){
                $lesSorties+=$sr->findBy(['datecloture'=>$dateFin]);
                $reset=true;
            }
            $lesSorties=$su->noDoublon($lesSorties);
            if(!$reset){
                $lesSorties=$sr->findAll();
            }
        }
        return $this->render('main/index.html.twig',
            compact('date','filtreForm','lesSorties')
        );
    }



}
