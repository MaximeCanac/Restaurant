<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class BlogController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/blog", name="blog_index")
     */
    public function index(): Response
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();

        return $this->render('blog/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show", requirements={"id": "\d+"})
     */
    public function show(Post $post): Response
    {
        return $this->render('blog/show.html.twig', [
            'post' => $post,
        ]);
    }
 
    /**
     * @Route("/blog/new", name="blog_new", methods={"GET", "POST"})
     */
    public function nouveau(Request $request): Response
    {
        $post = new Post();
        $post->setAutheur($this->getUser()->getUserIdentifier());
        $post->setDate(new \DateTime());

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('posts_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception
                }

                $post->setImage($newFilename);
            }

            $this->entityManager->persist($post);
            $this->entityManager->flush();

            return $this->redirectToRoute('blog.index');
        }

        return $this->render('blog/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/my-form", name="save_form_data", methods={"POST"})
     */
    public function saveFormData(Request $request): Response
    {
        // Récupérer les données du formulaire
        $name = $request->request->get('name');
        $message = $request->request->get('message');

        // Créer une nouvelle instance de l'entité Post
        $post = new Post();

        $post->setTitre($titre);
        $post->setContenu($contenu);
        

        // Enregistrer l'entité dans la base de données
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        // Répondre avec une réponse JSON pour la redirection
        return $this->json(['success' => true]);
    }
}
