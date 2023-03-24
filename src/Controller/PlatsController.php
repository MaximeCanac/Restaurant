<?php
// src/Controller/PlatsController.php

namespace App\Controller;

use App\Entity\Plats;
use App\Form\PlatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlatController extends AbstractController
{
    /**
     * @Route("/plats", name="plats")
     */
    public function plats(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlatType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entrees = $data['entrees'];
            $plats = $data['plats'];
            $desserts = $data['desserts'];

            // Enregistrer les plats sélectionnés
            $platsSelectionnes = array_merge($entrees, $plats, $desserts);
            $entityManager->getRepository(Plats::class)->savePlatsSelectionnes($platsSelectionnes);

            // Rediriger vers la page qui affiche les plats sélectionnés
            return $this->redirectToRoute('plats_selectionnes');
        }

        return $this->render('plat/plats.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/plats-selectionnes", name="plats_selectionnes")
     */
    public function platsSelectionnes(EntityManagerInterface $entityManager): Response
    {
        $platsSelectionnes = $entityManager->getRepository(Plats::class)->getPlatsSelectionnes();

        return $this->render('plat/plats_selectionnes.html.twig', [
            'plats' => $platsSelectionnes,
        ]);
    }
}
