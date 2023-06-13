<?php
//src/Controller/MenuController.php
namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Menu;
use App\Entity\ImageMenu;
use App\Form\ImageType;
use App\Form\MenuType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MenuController extends AbstractController
{
    #[Route(path: '/menu/creation', name: 'app_menu_creation')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Crée une nouvelle instance de l'entité Menu
        $menu = new Menu();
        $menu->setDateCreation(new \DateTime());
        $ImageMenu = new ImageMenu();

        // Crée un formulaire en utilisant le type de formulaire MenuType et l'entité Menu
        $form = $this->createForm(MenuType::class, $menu);

        // Crée un formulaire séparé pour l'image
        $imageForm = $this->createForm(ImageType::class, $ImageMenu);

        // Gère la soumission du formulaire principal et du formulaire d'image
        $form->handleRequest($request);
        $imageForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($menu);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_menu_last');
        }

        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $imageFile = $imageForm->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('menu_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer les erreurs de déplacement du fichier ici
                    
                }

                $ImageMenu->setImage($newFilename);
            }

            
            $entityManager->persist($ImageMenu);
            $entityManager->flush();
        }

        return $this->render('menu/index.html.twig', [
            'form' => $form->createView(),
            'imageForm' => $imageForm->createView(),
        ]);
    
    }
    
    #[Route(path: '/menu/last', name: 'app_menu_last')]
    public function last(EntityManagerInterface $entityManager): Response
    {
        // Récupère le dernier menu enregistré en se basant sur la date de création
        $menu = $entityManager->getRepository(Menu::class)->findOneBy([], ['id' => 'DESC']);
        $imageMenu = $entityManager->getRepository(ImageMenu::class)->findOneBy([], ['id' => 'DESC']);

        // Affiche le menu dans le template menu/show.html.twig
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
            'imageMenu' => $imageMenu,
        ]);
    }

    #[Route(path: '/menu/{id}', name: 'app_menu_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Menu $menu,ImageMenu $imageMenu): Response
    {
        // Affiche le menu spécifié dans le template menu/show.html.twig
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
            'imageMenu' => $imageMenu,
        ]);
    }

    #[Route(path: '/menu/generate-pdf', name: 'app_menu_generate-pdf')]
    public function generatePdf(EntityManagerInterface $entityManager): Response
    {
        // Récupérer le contenu du menu à partir de votre source de données
        $menu = $entityManager->getRepository(Menu::class)->findOneBy([], ['id' => 'DESC']); // Exemple avec une entité Menu
        $imageMenu = $entityManager->getRepository(ImageMenu::class)->findOneBy([], ['id' => 'DESC']);

        $imagePath = 'images/menu_directory/'. $imageMenu->getImage();
        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION); 

        // Lisez le fichier image et encodez-le en base64
        $imageData = base64_encode(file_get_contents($imagePath));

        // Rendre le template Twig pour le contenu du menu
        $html = $this->renderView('menu/menu_pdf.html.twig', [
            'menu' => $menu,
            'imageType' => $imageType,
            'imageData' => $imageData,
        ]);

        // Créer une instance de Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Facultatif) Configurer des options supplémentaires pour Dompdf

        // Rendre le HTML en PDF
        $dompdf->render();

        // Générer le nom du fichier PDF
        $filename = 'menu.pdf';

        // Récupérer le contenu PDF généré
        $output = $dompdf->output();

        // Envoyer le fichier PDF en réponse
        return new Response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
        ]);
    }
}
