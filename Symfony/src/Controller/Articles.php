<?php

namespace App\Controller;

use App\Entity\Article;
use App\Homework\ArticleContentProviderInterface;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Articles extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     * @param Article $article
     * @param ArticleRepository $repository
     * @return Response
     */
    public function homepage(ArticleRepository $repository, CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findLatest(3);

        return $this->render('articles/articles.html.twig', [
            'articles' => $repository->findByPublishBySort(),
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/articles/{slug}", name="app_article_show")
     * @param Article $article
     * @return Response
     */
    public function showArticle(Article $article) : Response
    {
        return $this->render('articles/detail.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @return string[]
     */
    public function getWords(): array
    {
        return [
            'color', 'word', 'green', 'house', 'yellow',
            'read', 'car', 'cat', 'dog', 'drink'
        ];
    }

    /**
     * @Route("/api/v1/article_content/", name="app_article_content", methods="POST")
     * @param ArticleContentProviderInterface $articleContent
     * @param Request $request
     * @return Response
     */
    public function articleContent(ArticleContentProviderInterface $articleContent, Request $request): Response
    {
        $paragraphs = $request->get('paragraphs');
        $word = $request->get('word');
        $wordsCount = $request->get('wordCount');

        return new Response(json_encode(['text' => $articleContent->get($paragraphs, $word, $wordsCount)]));
    }

    /**
     * @Route("/articles/{slug}/vote/{type<up|down>}", name="app_articles_vote", methods={"POST"})
     * @param Article $article
     * @param string $type
     * @return Response
     */
    public function like(Article $article, string $type, EntityManagerInterface $em): Response
    {
        if ($type === 'up') {
            $article->voteUp();
        }

        if ($type === 'down') {
            $article->voteDown();
        }

        $em->flush();

        return $this->json(["votes" => $article->getVoteCount()]);
    }
}
