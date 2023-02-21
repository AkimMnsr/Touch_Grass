<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\RegistrationFormType;
use App\Repository\ParticipantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/profil', name: 'profil_')]
class ProfilController extends AbstractController
{
    #[Route('/', name: 'afficher')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }

    #[Route('/modifier', name: 'modifier',)]
    public function edit(
        Request                $request,
        EntityManagerInterface $em,
    ): Response
    {
        $participant = $this->getUser();
        $registrationForm = $this->createForm(RegistrationFormType::class, $participant);
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted()&&$registrationForm->isValid()) {
            $participant = $registrationForm->getData();
            $em->persist($participant);
            $em->flush();
            $this->addFlash('success', 'Votre profil a bien été modifié');
            return $this->redirectToRoute('profil_afficher');
        }

        return $this->render('profil/modifier.html.twig',
            compact('participant', 'registrationForm')
        );
    }

    #[Route('/supprimer', name: 'supprimer')]
    public function delete(Request $request, Participants $participant, ParticipantsRepository $participantsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $participant->getId(), $request->request->get('_token'))) {
            $participantsRepository->remove($participant, true);
        }

        return $this->redirectToRoute('profil_afficher');
    }
}
