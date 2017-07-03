<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    public function multiple()
    {
        $articles = $this->get('app.article_repository')->findAll();
        $jsonArticles = [];
        foreach ($articles as $article) {
            $jsonArticles[] = ['id' => $article->getId()];
        }

        return new JsonResponse($jsonArticles);
    }
}
