<?php

namespace App\Controller;

use App\Form\CsvFormType;
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
    public function csvUpload(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(CsvFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $fichier = $form->get('csvFile')->getData();
            if ($fichier)
            {
                $tableur = IOFactory::load($fichier);
                $classeur = $tableur->getActiveSheet();
                $lignes = $classeur->toArray(
                    null,
                    true,
                    true,
                    true
                );
            }
        }
        return $this->render('importCsv/index.html.twig',
        compact('form'));
    }
}