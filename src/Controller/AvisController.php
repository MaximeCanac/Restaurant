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
use Symfony\Component\HttpFoundation\JsonResponse;

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

    #[Route('/api/form', name: 'app_api_form_submit', methods: ['POST'])]
    public function createAvis(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
    $data = json_decode($request->getContent(), true);   

    $avis = new Avis();

    $avis->setNote($data['satisfactionLevel']);
    $avis->setCommentaire($data['comment']);
    $avis->setDate(new \DateTime($data['date']));

    $entityManager->persist($avis);
    $entityManager->flush();

    return new JsonResponse(['message' => 'Avis créé avec succès'], JsonResponse::HTTP_CREATED);

    }
}

