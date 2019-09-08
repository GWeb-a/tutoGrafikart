<?php
/**
 * Created by PhpStorm.
 * User: Gianni GIUDICE
 * Date: 03/09/2019
 * Time: 13:45
 */

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController {

    /**
     * @var ArticleRepository
     */

    public function __construct(ArticleRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @Route("/articles", name="articles.index")
     * @return Response
     */
    public function index() : Response {
        $article = $this->repository->findAll();
        dump($article);
        return $this->render('pages/articles.html.twig', [ 'current_page' => 'articles' ]);
    }

    /**
     * @Route("/articles/{slug}-{id}", name="articles.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Article $article, string $slug) : Response {
        if ($article->getSlug() !== $slug) {
            return $this->redirectToRoute('articles.show', [
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ], 301);
        }
        return $this->render('pages/show_article.html.twig', [
            'article' => $article,
            'current_page' => 'articles' ]);
    }

}