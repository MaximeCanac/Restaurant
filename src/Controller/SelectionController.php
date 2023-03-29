<?php
// src/Controller/SelectionController.php

namespace App\Controller;

use App\Entity\Plats;
use App\Form\SelectionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SelectionController extends AbstractController
{
    
    #[Route('/selection', name: 'selection')]
    public function selection(Request $request): Response
    {
        $form = $this->createForm(SelectionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entrees = $form->get('entrees')->getData();
            $plats = $form->get('plats')->getData();
            $desserts = $form->get('desserts')->getData();

            return $this->render('selection/selection.html.twig', [
                
                'entrees' => $entrees,
                'plats' => $plats,
                'desserts' => $desserts,
                
            ]);
        }

        return $this->render('selection/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
