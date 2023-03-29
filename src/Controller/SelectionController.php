<?php
// src/Controller/SelectionController.php

namespace App\Controller;

use App\Entity\Plats;
use App\Entity\Selection;
use App\Form\SelectionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class SelectionController extends AbstractController
{
    
    #[Route('/selection', name: 'selection')]
    public function selection(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SelectionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entrees = $form->get('entrees')->getData();
            $plats = $form->get('plats')->getData();
            $desserts = $form->get('desserts')->getData();

// Créez une instance de l'entité Selection et définit ses propriétés
            $selection = new Selection();
            $selection->setEntrees($entrees);
            $selection->setPlats($plats);
            $selection->setDesserts($desserts);

 // Persiste l'objet dans la base de données
            $entityManager->persist($selection);
            $entityManager->flush();

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
