<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/admin/articles', name: 'app_admin_articles')]
    #[IsGranted('ROLE_ADMIN_ARTICLE')]
    public function index(
        Request $request,
        ArticleRepository $articleRepository,
        PaginatorInterface $paginator,
    ) {
        $articles = $articleRepository->findAllWithSearchQuery(
            $request->query->get('q'),
        );

        $pagination = $paginator->paginate(
            $articles,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/admin_articles.html.twig', [
            'articles' => $pagination
        ]);
    }

    #[Route('/admin/article/create', name: 'app_admin_article_create')]
    #[IsGranted('ROLE_ADMIN_ARTICLE')]
    public function create(
        Request $request,
        EntityManagerInterface $em,
        FileUploader $articleFileUploader
    ): Response {
        $form = $this->createForm(ArticleFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();

            $image = $form->get('image')->getData();

            $article->setImageFilename($articleFileUploader->uploadFile($image));

            $em->persist($article);
            $em->flush();

            $this->addFlash('flash_message', 'Статья успешно создана');

            return $this->redirectToRoute('app_admin_articles');
        }

        return $this->render('admin/article/create.html.twig', [
            'article' => $form->createView(),
            'showError' => $form->isSubmitted()
        ]);
    }

    #[Route('/admin/article/{id}/edit', name: 'app_admin_article_edit')]
    #[IsGranted('MANAGE', subject: 'article')]
    public function edit(
        Article $article,
        EntityManagerInterface $em,
        Request $request,
        FileUploader $articleFileUploader
    ): Response {
        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();

            /** @var UploadedFile|null $image */
            $image = $form->get('image')->getData();

            if ($image) {
                $article->setImageFilename($articleFileUploader->uploadFile($image, $article->getImageFilename()));
            }

            $em->persist($article);
            $em->flush();

            $this->addFlash('flash_message', 'Статья успешно изменена');

            return $this->redirectToRoute('app_admin_article_edit', ['id' => $article->getId()]);
        }

        return $this->render('admin/article/edit.html.twig', [
            'article' => $form->createView(),
            'showError' => $form->isSubmitted()
        ]);
    }
}
