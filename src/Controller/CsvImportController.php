<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\CsvFormType;
use App\Repository\SitesRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CsvImportController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/insert', name: 'app_insert')]
    public function csvUpload(EntityManagerInterface $em, Request $request, SitesRepository $sitesRepository)
    {
        $sites = $sitesRepository->findAll();
        $form = $this->createForm(CsvFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $fichier = $form->get('csvFile')->getData();

            if ($fichier) {
                $tableur = IOFactory::load($fichier);
                $classeur = $tableur->getActiveSheet();
                $lignes = $classeur->toArray(
                    null,
                    true,
                    true,
                    true
                );

                foreach ($lignes as $ligne) {
                    $user = new Participants();
                    $user->setPseudo($ligne['A']);
                    $user->setSitesNoSite($sitesRepository->find($ligne['B']));
                    $user->setNom($ligne['C']);
                    $user->setPrenom($ligne['D']);
                    $user->setTelephone($ligne['E']);
                    $user->setMail($ligne['F']);
                    $user->setAdministrateur(false);
                    $user->setActif(true);
                    $user->setRoles([]);
                    $user->setPassword($ligne['G']);
                    $em->persist($user);
                }
                $em->flush();
                $this->addFlash('success','Tous les participants ont étés insérés');
                return $this->render('profil/index.html.twig');
            }
        }
        return $this->render('importCsv/index.html.twig',
            compact('form', 'sites'));
    }
}