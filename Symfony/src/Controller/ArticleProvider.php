<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleProvider extends AbstractController
{
    /**
     * @return array[]
     */
    public function articles() : array
    {
         return [
            [
                'title' => 'Когда пролил кофе на клавиатуру',
                'slug' => 'spilled-coffee-on-the-keyboard',
                'image' => 'images/article-3.jpg'
            ],
            [
                'title' => 'Что делать, если надо верстать?',
                'slug' => 'what-to-do-if-you-need-to-type',
                'image' => 'images/article-2.jpeg'
            ],
            [
                'title' => 'Facebook ест твои данные',
                'slug' => 'facebook-eats-your-data',
                'image' => 'images/article-1.jpeg'
            ],
        ];
    }

    /**
     * @return array
     */
    public function article() : array
    {
        $articles = $this->articles();
        $randNumber = rand(0, count($articles) - 1);

        return $articles[$randNumber];
    }
}