<?php

namespace App\Controller;

use App\Entity\Inscriptions;
use App\Entity\Lieux;
use App\Entity\Sorties;
use App\Form\AddLieuType;
use App\Form\AddSortieType;
use App\Form\CancelType;
use App\Repository\EtatsRepository;
use App\Repository\LieuxRepository;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use phpDocumentor\Reflection\Types\String_;
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
        Request $request,
        LieuxRepository $lieuxRepository
    ) : Response
    {

        $sortie = new Sorties();
        $lieu = $lieuxRepository->findAll();
        $sortieForm = $this->createForm(AddSortieType::class,$sortie);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted()) {
            try {
                $organisateur = $this->getUser();
                $sortie->setOrganisateur($organisateur);
                $inscription = new Inscriptions();
                $inscription->setDateInscription($sortie->getDatedebut());
                $sortie->setIdInscription($inscription);
                $inscription->addParticipantsNoParticipant($organisateur);
                dump($sortie);
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
            'formSortie' => $sortieForm->createView(),
            'lieu' => $lieu
        ]);

    }

    // Function Adding 'lieu'
    #[IsGranted('ROLE_USER')]
    #[Route('/addLieu', name: 'addLieu')]
    public function addLieu(
        EntityManagerInterface $em,
        Request $request
    ):Response{

        $lieu = new Lieux();
        $formLieu = $this->createForm(AddLieuType::class, $lieu);
        $formLieu->handleRequest($request);

        if ($formLieu->isSubmitted()){
            try {
                if( $formLieu->get("save")->isClicked()){
                    if ($formLieu->isValid()) {
                        $em->persist($lieu);
                        $em->flush();
                            return $this->redirectToRoute('sortie_addSortie');
                    }
                }
            } catch (Exception $exception){
                $exception->getMessage();
            }
        }
        return $this->render('sortie/addLieu.html.twig',
            compact('formLieu')
        );

    }

    // Function Adding 'lieu' for modification dont know how to redirect to the previous page so i make it in double sorry Julien
    #[IsGranted('ROLE_USER')]
    #[Route('/LieuSortie/{id}', name: 'LieuSortie')]
    public function LieuSortie(
        int $id,
        EntityManagerInterface $em,
        Request $request,
        SortiesRepository $sortiesRepository,
    ):Response{

        $lieusortie = new Lieux();
        $sortie = $sortiesRepository->findOneBy(["id" =>$id]);
        $formLieu = $this->createForm(AddLieuType::class, $lieusortie);
        $formLieu->handleRequest($request);

        if ($formLieu->isSubmitted()){
            try {
                if( $formLieu->get("save")->isClicked()){
                    if ($formLieu->isValid()) {
                        $em->persist($lieusortie);
                        $em->flush();
                        $idSortie = $sortie->getId();
                        return $this->redirectToRoute('sortie_sortie', array('id' =>$idSortie));
                    }
                }
            } catch (Exception $exception){
                $exception->getMessage();
            }
        }
        return $this->render('sortie/addLieusortie.html.twig',
            compact('formLieu', 'sortie')
        );

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
        LieuxRepository $lieuxRepository,
    ): Response
    {
        $owner = $this->getUser();
        $lieu = $lieuxRepository->findAll();
        $sortie = $sortiesRepository->findOneBy(["id" =>$id]);
        if ($sortie->getOrganisateur() === $owner ){

            $sortieModif = $this->createForm(AddSortieType::class,$sortie);
            $sortieModif->handleRequest($request);
            $sortie->getLieuxNoLieu();
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
                        $this->addFlash('remove', 'La sortie a bien été supprimée');
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
                'sortie' => $sortie,
                'lieu' => $lieu
            ] );
        } else {
            return $this->render('sortie/sortie.html.twig',
                [
                    'sortie' => $sortie
                ]
            );
        }
    }

    //Function for cancel a 'sortie'
    #[IsGranted('ROLE_USER')]
    #[Route('/annuler/{id}', name: 'annuler')]
    public function annuler(
        int $id,
        Request $request,
        SortiesRepository $sortiesRepository,
        EntityManagerInterface $em,
        EtatsRepository $etatsRepository,

    ) : Response
    {
        $owner = $this->getUser();
        $sortie = $sortiesRepository->findOneBy(["id" => $id]);

        if ($sortie->getOrganisateur() === $owner ){
        $cancelForm = $this->createForm(CancelType::class, $sortie);
        $cancelForm->handleRequest($request);
            if($cancelForm->isSubmitted()){
                try {
                    $cancel = $etatsRepository->findOneBy(['id' => 5]);
                    $sortie->setEtatsNoEtat($cancel);
                    if($cancelForm->isValid()) {
                        $sortie->setDescriptioninfos("Motif de l'annulation : ".$sortie->getDescriptioninfos());
                        $em->persist($sortie);
                        $em->flush();
                        $this->addFlash('sucess', 'La sortie a bien été annulée');
                        return $this->redirectToRoute('main_index');
                    }
                } catch (Exception $exception) {
                    dd($exception->getMessage());
                }
            }

        return $this->render('sortie/annuler.html.twig', [
            'sortie' => $sortie,
            'cancelForm' => $cancelForm->createView(),

        ]);
        }
        return $this->trolling();
    }


    #[Route('/troll', name: 'troll')]
    public function trolling() {
            return $this->render('sortie/trolling.html.twig');
    }




}



