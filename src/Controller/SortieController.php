<?php

namespace App\Controller;

use App\Entity\Inscriptions;
use App\Entity\Sorties;
use App\Form\AddSortieType;
use App\Repository\EtatsRepository;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/sortie', name: 'sortie_')]
class SortieController extends AbstractController
{

    // Function Adding 'sortie'
    #[IsGranted('ROLE_USER')]
    #[Route('/addSortie', name: 'addSortie')]
    public function addSortie(
        EntityManagerInterface $em,
        EtatsRepository $etatsRepository,
        Request $request
    ) : Response
    {


        $sortie = new Sorties();
        $sortieForm = $this->createForm(AddSortieType::class,$sortie);
        $sortieForm->handleRequest($request);
        $organisateur = $this->getUser();
        $sortie->setOrganisateur($organisateur);

        if ($sortieForm->isSubmitted()) {
            try {
                $inscription = new Inscriptions();
                $inscription->setDateInscription($sortie->getDatedebut());
                $sortie->setIdInscription($inscription);
               if( $sortieForm->get("save")->isClicked()) {
                   $save = $etatsRepository->findOneBy(['id' => 1]);
                   $sortie->setEtatsNoEtat($save);
               } else {
                   $publish = $etatsRepository->findOneBy(['id' => 2]);
                   $sortie->setEtatsNoEtat($publish);
               };
                if ($sortieForm->isValid()) {
                    $em->persist($inscription);
                    $em->persist($sortie);
                    $em->flush();
                    $idSortie = $sortie->getId();
                    return $this->redirectToRoute('sortie_sortie', array('id' =>$idSortie));
                }

            } catch (Exception $exception) {
                dd($exception->getMessage());
            }
        }
        return $this->render('sortie/addSortie.html.twig',[
            'formSortie' => $sortieForm->createView()
        ]);

    }
    // Function have two function :
    // First one : Participant can only show sortie
    // Second : Owner of sortie can modify sortie
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}', name: 'sortie')]
    public function sortie(
        EntityManagerInterface $em,
        Request $request,
        int $id,
        SortiesRepository $sortiesRepository,
        EtatsRepository $etatsRepository,

    ): Response
    {
        $owner = $this->getUser();
        $sortie = $sortiesRepository->findOneBy(["id" =>$id]);
        if ($sortie->getOrganisateur() === $owner ){

            $sortieModif = $this->createForm(AddSortieType::class,$sortie);
            $sortieModif->handleRequest($request);
            if ($sortieModif->isSubmitted()) {
                try {

                    if( $sortieModif->get("save")->isClicked()) {
                        $save = $etatsRepository->findOneBy(['id' => 1]);
                        $sortie->setEtatsNoEtat($save);
                    } else {
                        $publish = $etatsRepository->findOneBy(['id' => 2]);
                        $sortie->setEtatsNoEtat($publish);
                    }
                    if ($sortieModif->get("remove")->isClicked()){
                        $em->remove($sortie);
                        $em->flush();
                        return $this->redirectToRoute('main_index');
                    }
                    if ($sortieModif->isValid()) {
                        $em->persist($sortie);
                        $em->flush();
                        $idSortie = $sortie->getId();
                        $this->addFlash('sucess', 'La sortie a bien été modifiée');
                        return $this->redirectToRoute('sortie_sortie', array('id' =>$idSortie));
                    }

                } catch (Exception $exception) {
                    dd($exception->getMessage());
                }
            }

            return $this->render('sortie/sortie.html.twig', [
                'formSortie' => $sortieModif->createView(),
                'sortie' => $sortie
            ] );
        } else {
            return $this->render('sortie/sortie.html.twig',
                [
                    'sortie' => $sortie
                ]
            );
        }
    }


}

