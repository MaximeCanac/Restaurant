<?php
// src/Controller/AjoutController.php

namespace App\Controller;

use App\Entity\Dessert;
use App\Entity\Entree;
use App\Entity\Plat;
use App\Form\EntreeType;
use App\Form\PlatType;
use App\Form\DessertType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AjoutController extends AbstractController
{
    
    #[Route('/menu/ajout', name: 'app_ajout')]
    public function Ajout(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entree = new Entree();
        $plat = new Plat();
        $dessert = new Dessert();
        
        
        
        $formEntree = $this->createForm(EntreeType::class, $entree);
        $formPlat = $this->createForm(PlatType::class, $plat);
        $formDessert = $this->createForm(DessertType::class, $dessert);
        
        $formEntree->handleRequest($request);
        $formPlat->handleRequest($request);
        $formDessert->handleRequest($request);
        
        if ($formEntree->isSubmitted() && $formEntree->isValid()) {
            
            $entityManager->persist($entree);
            $entityManager->flush();
            $this->addFlash('success', 'L\'entrée a bien été ajoutée.');
            return $this->redirectToRoute('app_ajout');
        }
        
        if ($formPlat->isSubmitted() && $formPlat->isValid()) {
           
            $entityManager->persist($plat);
            $entityManager->flush();
            $this->addFlash('success', 'Le plat a bien été ajouté.');
            return $this->redirectToRoute('app_ajout');
        }
        
        if ($formDessert->isSubmitted() && $formDessert->isValid()) {
            
            $entityManager->persist($dessert);
            $entityManager->flush();
            $this->addFlash('success', 'Le dessert a bien été ajouté.');
            return $this->redirectToRoute('app_ajout');
        }
        
        return $this->render('ajout/index.html.twig', [
            'formEntree' => $formEntree->createView(),
            'formPlat' => $formPlat->createView(),
            'formDessert' => $formDessert->createView(),
        ]);
    }
}

