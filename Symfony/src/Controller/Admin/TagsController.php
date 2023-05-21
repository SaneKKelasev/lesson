<?php

namespace App\Controller\Admin;

use App\Repository\TagRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN_TAG')]
class TagsController extends AbstractController
{
    #[Route('/admin/tags', name: 'app_admin_tags')]
    public function index(
        Request $request,
        TagRepository $tagRepository,
        PaginatorInterface $paginator): Response
    {
        $tags = $tagRepository->findAllWithSearchQuery(
            $request->query->get('q'),
            $request->query->has('isDeleted'),
        );

        $pagination = $paginator->paginate(
            $tags, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('admin/tags/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
