<?php
/**
 * Created by PhpStorm.
 * User: Gianni GIUDICE
 * Date: 05/09/2019
 * Time: 15:45
 */

namespace App\Controller\Admin;


use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticlesController extends AbstractController {
    private $repository;
    private $em;

    public function __construct(ArticleRepository $repository, ObjectManager $em) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.articles.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index() {
        $articles = $this->repository->findAll();
        return $this->render('pages/admin/index.html.twig', [ 'articles' => $articles ]);
    }

    /**
     * @Route("/admin/articles/{id}", name="admin.articles.edit", methods="GET|POST")
     */
    public function edit(Article $article, Request $request) {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        /* Si le formulaire a été envoyé et est bien valide */
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('admin.articles.index');
        }

        return $this->render('pages/admin/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView()]);
    }

    /**
     * @Route("/admin/articles/create", name="admin.articles.create")
     */
    public function new(Request $request) {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        /* Si le formulaire a été envoyé et est bien valide */
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setAuthorId(1);
            $this->em->persist($article);
            $this->em->flush();
            return $this->redirectToRoute('admin.articles.index');
        }

        return $this->render('pages/admin/new.html.twig', [
            'article' => $article,
            'form' => $form->createView()]);
    }

    /**
     * @Route("/admin/articles/{id}", name="admin.articles.delete", methods="DELETE")
     */
    public function delete(Article $article, Request $request) {

    }
}