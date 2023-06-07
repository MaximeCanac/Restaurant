<?php
//src/Controller/MenuController.php
namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Menu;
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

        // Crée un formulaire en utilisant le type de formulaire MenuType et l'entité Menu
        $form = $this->createForm(MenuType::class, $menu);

        // Gère la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Génère un nom de fichier unique pour éviter les collisions
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Déplace le fichier vers un répertoire spécifique
                try {
                    $imageFile->move(
                        $this->getParameter('menu_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer les erreurs de déplacement du fichier ici
                }

                // Met à jour la propriété imagePath de l'entité Menu avec le chemin du fichier
                $menu->setImage($newFilename);
            }
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

    #[Route(path: '/menu/generate-pdf', name: 'app_menu_generate-pdf')]
    public function generatePdf(EntityManagerInterface $entityManager): Response
    {
        // Récupérer le contenu du menu à partir de votre source de données
        $menu = $entityManager->getRepository(Menu::class)->findOneBy([], ['dateCreation' => 'DESC']); // Exemple avec une entité Menu

        // Rendre le template Twig pour le contenu du menu
        $html = $this->renderView('menu/menu_pdf.html.twig', [
            'menu' => $menu,
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
