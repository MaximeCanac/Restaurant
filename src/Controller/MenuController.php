<?php

// src/Controller/MenuController.php
namespace App\Controller;

use App\Entity\Plats;
use App\Form\EnregistrementMenuType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MenuController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/menu', name: 'app_menu')]
    public function index(Request $request): Response
    {
        $plats = $this->entityManager
            // récupérer tous les plats dans la base de données
            ->getRepository(Plats::class)
            ->findAll();

        // créer un formulaire pour sélectionner les entrées, plats et desserts
        $form = $this->createForm(EnregistrementMenuType::class, null, ['plats' => $plats]);
        $form->handleRequest($request);
    
        // si le formulaire a été soumis et est valide, afficher les plats sélectionnés
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
    
            // récupérer les plats sélectionnés pour chaque catégorie
            $entrees = $this->entityManager
                ->getRepository(Plats::class)
                ->findById($data->getEntrees());
            $plats = $this->entityManager
                ->getRepository(Plats::class)
                ->findById($data->getPlats());
            $desserts = $this->entityManager
                ->getRepository(Plats::class)
                ->findById($data->getDesserts());
    
            // afficher les plats sélectionnés dans une vue
            return $this->render('menu/index.html.twig', [
                'entrees' => $entrees,
                'plats' => $plats,
                'desserts' => $desserts,
            ]);
        }
    
        // afficher le formulaire
        return $this->render('menu/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

