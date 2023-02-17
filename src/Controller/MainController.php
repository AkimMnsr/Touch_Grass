<?php

namespace App\Controller;

use App\Form\FiltreType;
use App\Helper\ServiceUtilitaire;
use App\Repository\ParticipantsRepository;
use App\Repository\SortiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(Request $request, SortiesRepository $sr, ParticipantsRepository $pr, ServiceUtilitaire $su): Response
    {
        $reset = true;
        $lesSorties = [];
        $date = new \DateTime();
        $filtreForm = $this->createForm(FiltreType::class);
        $filtreForm->handleRequest($request);
        if ($filtreForm->isSubmitted()) {

            $site = $request->get("filtre")['site'];
            $nom = $request->get("filtre")["nom"];
            $dateDeb =$request->get("filtre")['datedebut'];
            $dateFin = $request->get("filtre")['datecloture'];
            dump($dateFin);

            if ($site != null || $site != "") {
                $lesSorties += $sr->findBy([
                    'organisateur' => $pr->findBy([
                        'sites_no_site' => $site
                    ])
                ]);
                $reset = false;
            }
            if ($nom != null || $nom != "") {
                $lesSorties += $sr->findByNom($nom);
                $reset = false;
            }
            if ($dateDeb != null) {
                $lesSorties += $sr->findByDateFin($dateDeb);
                $reset = false;
            }
            if ($dateFin != null) {
                $lesSorties += $sr->findByDateFin($dateFin);
                $reset = false;
            }
            if(!$reset){
                $lesSorties = $su->noDoublon($lesSorties);
            }
        }
        if ($reset) {
            if ($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN')) {
                $lesSorties = $sr->findAllBasic($this->getUser()->getId());
            } else {
                $lesSorties = $sr->findBy(['etats_no_etat' => 1]);
            }
        }
        return $this->render('main/index.html.twig',
            compact('date', 'filtreForm', 'lesSorties')
        );
    }


}
