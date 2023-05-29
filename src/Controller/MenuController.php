<?php
//src/Controller/MenuController.php
namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MenuController extends AbstractController
{
    #[Route(path: '/menu/creation', name: 'app_menu_creation')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Crée une nouvelle instance de l'entité Menu
        $menu = new Menu();
        $menu->setDateCreation(new \DateTime());

        // Crée un formulaire en utilisant le type de formulaire MenuType et l'entité Menu
        $form = $this->createForm(MenuType::class, $menu);

        // Gère la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide, persiste l'entité Menu en base de données
            $entityManager->persist($menu);
            $entityManager->flush();

            // Redirige vers la page d'affichage du menu nouvellement créé
            return $this->redirectToRoute('app_menu_show', ['id' => $menu->getId()]);
        }

        // Affiche le formulaire dans le template menu/index.html.twig
        return $this->render('menu/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route(path: '/menu/last', name: 'app_menu_last')]
    public function last(EntityManagerInterface $entityManager): Response
    {
        // Récupère le dernier menu enregistré en se basant sur la date de création
        $menu = $entityManager->getRepository(Menu::class)->findOneBy([], ['dateCreation' => 'DESC']);

        // Affiche le menu dans le template menu/show.html.twig
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    #[Route(path: '/menu/{id}', name: 'app_menu_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Menu $menu): Response
    {
        // Affiche le menu spécifié dans le template menu/show.html.twig
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }
}
