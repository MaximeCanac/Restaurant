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
        $menu = new Menu();
        $menu->setDateCreation(new \DateTime());
        $form = $this->createForm(MenuType::class, $menu);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($menu);
            $entityManager->flush();

            return $this->redirectToRoute('app_menu_show', ['id' => $menu->getId()]);
        }

        return $this->render('menu/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route(path: '/menu/last', name: 'app_menu_last')]
    public function last(EntityManagerInterface $entityManager): Response
    {
        $menu = $entityManager->getRepository(Menu::class)->findOneBy([], ['dateCreation' => 'DESC']);

        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    #[Route(path: '/menu/{id}', name: 'app_menu_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Menu $menu): Response
    {
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }
}
