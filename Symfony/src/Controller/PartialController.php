<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\containsEqual;

class PartialController extends AbstractController
{
    /**
     * @return Response
     */
    public function renderLastComments(
        HttpKernelInterface $kernel
    ): Response
    {
        $request = new Request();
        $request->attributes->set('_controller', 'App\Controller\PartialController::lastComments');

        $response = $kernel->handle($request, HttpKernelInterface::SUB_REQUEST);

        $comments = [];

        if ($content = $response->getContent()) {
            $comments = json_decode($content);
        }

        return $this->render('partial/lastComments.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @return Response
     */
    public function lastComments(): Response
    {
        $comments = [
            [
                'content' => 'Tenetur voluptatem ipsa architecto voluptatum magni. A dignissimos nesciunt ad quam dolores. Maiores voluptatem quo eligendi molestias aspernatur velit.',
                'author' => 'Василий ПиЭйчПи, Программист Ruby',
            ],
            [
                'content' => 'Et voluptatem ullam occaecati id. Et voluptas aliquam eveniet recusandae. Sit natus explicabo qui id natus qui aut ut.',
                'author' => 'Елена Прекрасная, царевна',
            ],
            [
                'content' => 'Eveniet qui atque ratione soluta. Iste dolor reprehenderit illo beatae dolores non voluptas delectus. Quibusdam expedita veniam earum culpa. Beatae voluptatem vel qui et.',
                'author' => 'Пушкин Александр Сергеевич, поэт и много кто еще',
            ],
        ];

        shuffle($comments);

        return $this->json($comments);
    }
}
