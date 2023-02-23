<?php

namespace App\Controller;

use App\Repository\ParticipantsRepository;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class InscriptionController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/inscription/{id}', name: 'inscription_inscription')]
    public function inscription(
        int                    $id,
        ParticipantsRepository $participantsRepository,
        SortiesRepository      $sortiesRepository,
        EntityManagerInterface $em,
        Request                $request
    ): Response
    {


        $inscrit = $this->getUser()->getUserIdentifier();
        $user = $participantsRepository->findOneBy(["pseudo" => $inscrit]);
        $sortie = $sortiesRepository->findOneBy(["id" => $id]);
        $inscription = $sortie->getIdInscription();
        dump($user);
        dump($inscription);
        if ($user->getUserId() !== $inscription->getParticipantsNoParticipant()) {
            $inscription->addParticipantsNoParticipant($user);
            $em->persist($inscription);
            $em->persist($user);
            $em->flush();
        }
        return $this->redirectToRoute('main_index');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/desinscription/{id}', name: 'inscription_desinscription')]
    public function desinscription(
        int                    $id,
        ParticipantsRepository $participantsRepository,
        SortiesRepository      $sortiesRepository,
        EntityManagerInterface $em,
        Request                $request
    ): Response
    {
        $inscrit = $this->getUser()->getUserIdentifier();
        $user = $participantsRepository->findOneBy(["pseudo" => $inscrit]);
        $sortie = $sortiesRepository->findOneBy(["id" => $id]);
        $inscription = $sortie->getIdInscription();
        if ($inscrit !== $inscription) {
            $inscription->removeParticipantsNoParticipant($user);
            $em->persist($inscription);
            $em->persist($user);
            $em->flush();
        }
        return $this->redirectToRoute('main_index');
    }

}

