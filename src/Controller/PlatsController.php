<?php

namespace App\Controller;

use App\Entity\Plats;
use App\Form\PlatsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Reponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PlatsController extends AbstractController
{
    
    #[Route('/plats', name: 'plats')]
    public function plats(Request $request, EntityManagerInterface $entityManager)
    {
        $plats = $entityManager->getRepository(Plats::class)->findAll();

        $form = $this->createForm(PlatsFormType::class, null, [
            'plats' => $plats,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entrees = $data['entrees'];
            $plats = $data['plats'];
            $desserts = $data['desserts'];

            return $this->render('plats/selection.html.twig', [
                'entrees' => $entrees,
                'plats' => $plats,
                'desserts' => $desserts,
            ]);
        }

        return $this->render('plats/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
