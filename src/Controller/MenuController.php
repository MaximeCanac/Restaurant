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

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route(path: '/menu/creation', name: 'menu_creation')]
    public function create(Request $request): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->entityManager->persist($menu);
            $this->entityManager->flush();

            return $this->redirectToRoute('menu_show', ['id' => $menu->getId()]);
        }

        return $this->render('menu/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route(path: '/menu/{id}', name: 'menu_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Menu $menu): Response
    {
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }
}
