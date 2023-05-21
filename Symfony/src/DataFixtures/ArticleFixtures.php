<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Repository\UserRepository;
use App\Services\FileUploader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    private static $articleTitles = [
        'Когда пролил кофе на клавиатуру',
        'Facebook ест твои данные',
        'Что делать, если надо верстать?'
    ];

    private static $articleImagesPath = [
        'article-1.jpeg',
        'article-2.jpeg',
        'article-3.jpg',
    ];

    private ObjectManager $manager;

    private  $faker;

    public function __construct(
        protected UserRepository $userRepository,
        protected FileUploader $articleFileUploader
    ) {
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        for ($i = 0; $i <= 5; $i++) {
            $article = new Article();

            $fileName = $this->faker->randomElement(self::$articleImagesPath);

            $tmpFileName = sys_get_temp_dir() . '/' . $fileName;


            $article
                ->setAuthor($this->userRepository->findOneBy(['email' => 'admin@symfony.skillbox']))
                ->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setDescription('brief description of the article')
                ->setImageFileName($this->articleFileUploader->uploadFile(new File(dirname(dirname(__DIR__)) . '/public/images/' . $fileName)))
                ->setKeywords(0)
                ->setBody(
                    "[My name is Aleksasendr](/).I am a university student. 
                    Every day I have three or four classes, so I do not usually have much time for meals. 
                    CThey all live in the village, where my parents come from."
                    . $this->faker->paragraphs($this->faker->numberBetween(1, 5), true)
                );

            if ($this->faker->boolean(60)) {
                $article
                    ->setPublishedAt($this->faker->dateTimeBetween('-50 days', '1 days'))
                    ->setVoteCount($this->faker->numberBetween(0 , 10));
            }

            $numRand = $this->faker->numberBetween(2, 10);

            while ($numRand--) {
                $this->addComments($article);
            }

            $randNum = $this->faker->numberBetween(3, 5);

            while ($randNum--) {
                $this->addTag($article);
            }

            $manager->persist($article);
        }

        $manager->flush();
    }

    /**
     * @param \Faker\Generator $faker
     * @param Article $article
     * @param ObjectManager $manager
     * @return void
     */
    public function addComments(Article $article): void
    {
        $comment = (new Comment())
            ->setAuthorName('admin')
            ->setContent($this->faker->paragraphs(1, true))
            ->setCreatedAt($this->faker->dateTimeBetween('-50 days', '-1 day'))
            ->setArticle($article);

        if ($this->faker->boolean) {
            $comment->setDeletedAt($this->faker->dateTimeThisMonth());
        }

        $this->manager->persist($comment);
    }

    public function addTag(Article $article)
    {
        $tag = (new Tag())
            ->setName($this->faker->realText(15))
            ->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 day'))
            ->addArticle($article);

        if ($this->faker->boolean) {
            $tag
                ->setDeletedAt($this->faker->dateTimeBetween('-100 days', '-1 day'));
        }

        $this->manager->persist($tag);
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
