<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted("ROLE_ADMIN_COMMENT")]
class CommentsController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/comments', name: 'app_admin_comments')]
    public function index(Request $request, CommentRepository $commentRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $comments = $commentRepository->findAllWithSearch(
            $request->query->get('q'),
            $request->query->has('showDeleted'),
        );

        return $this->render('admin/comments/index.html.twig', [
            'comments' => $comments,
        ]);
    }
}
