<?php

namespace App\Controller;


use SkillboxSymfony\ArticleContentProviderBundle\ArticleContentProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleContentController extends AbstractController
{
    #[Route('/article_content"', name: "app_article_content", methods: 'GET')]
    public function articleContent(Request $request, ArticleContentProvider $articleContentProvider): Response
    {
        $paragraphs = (int)$request->get('paragraphs');
        $word       = $request->get('word');
        $wordsCount = (int)$request->get('wordsCount');

        $articleContent = $articleContentProvider->get($paragraphs, $word, $wordsCount);

        return $this->render('articles/content.html.twig', [
            'articleContent' => $articleContent,
        ]);
    }
}
