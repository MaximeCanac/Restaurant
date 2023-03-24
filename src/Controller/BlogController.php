<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Post;
use App\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{postId}", name="blog_show")
     */
    public function show($postId, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository(Post::class)->find($postId);

        if (!$post) {
            throw $this->createNotFoundException('The post does not exist');
        }

        $blog = new Blog();
        $blog->setPost($post);

        $form = $this->createForm(BlogType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('blog_show', ['postId' => $postId]);
        }

        $blogEntries = $entityManager->getRepository(Blog::class)->findBy(['post' => $post]);

        return $this->render('blog/show.html.twig', [
            'post' => $post,
            'blogEntries' => $blogEntries,
            'form' => $form->createView(),
        ]);
    }
}
