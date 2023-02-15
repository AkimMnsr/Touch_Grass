<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Entity\Sites;
use App\Form\RegistrationFormType;
use App\Repository\ParticipantsRepository;
use App\Repository\SitesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        Request $request,
        ParticipantsRepository $participantsRepository
    ): Response
    {
        $participant = new Participants();
        $participant->setPseudo($this->getUser()->getPseudo());
        $participant->setPrenom($this->getUser()->getPrenom());
        $participant->setNom($this->getUser()->getNom());
        $participant->setTelephone($this->getUser()->getTelephone());
        $participant->setMail($this->getUser()->getMail());
        $participant->setSitesNoSite($this->getUser()->getSitesNoSite());
        $registrationForm = $this->createForm(RegistrationFormType::class, $participant);
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $participantsRepository->save($participant, true);

            return $this->redirectToRoute('profil_afficher');
        }

        return $this->render('profil/modifier.html.twig',
            compact('participant', 'registrationForm')
        );
    }
    #[Route('/supprimer', name: 'supprimer')]
    public function delete(Request $request, Participants $participant, ParticipantsRepository $participantsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $participantsRepository->remove($participant, true);
        }

        return $this->redirectToRoute('profil_afficher');
    }
}
