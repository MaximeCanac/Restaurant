<?php
// src/Controller/AvisController.php

namespace App\Controller;

use App\Repository\AvisRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AvisController extends AbstractController
{
    #[Route('/avis', name: 'app_avis')]
    public function index(AvisRepository $avisRepository): Response
    {
        $avis = $avisRepository->findAll();

        return $this->render('avis/index.html.twig', [
            'avis' => $avis,
        ]);
    }
}

