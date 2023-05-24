<?php
// src/Controller/AvisController.php

namespace App\Controller;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

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

    public function createAvis(Request $request, EntityManagerInterface $entityManager)
{
    $data = json_decode($request->getContent(), true);

    $avis = new Avis();
    $avis->setAuteur($data['auteur']);
    $avis->setNote($data['note']);
    $avis->setCommentaire($data['commentaire']);
    $avis->setDate(new \DateTime($data['date']));

    $entityManager->persist($avis);
    $entityManager->flush();

    
}
}

