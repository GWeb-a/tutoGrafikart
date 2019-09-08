<?php
/**
 * Created by PhpStorm.
 * User: Gianni GIUDICE
 * Date: 03/09/2019
 * Time: 11:44
 */

namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(ArticleRepository $repository) : Response {
        $articles = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'articles' => $articles
        ]);
    }
}