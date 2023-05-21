<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class ArticleFormType extends AbstractType
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Article|null $article */
        $article = $options['data'] ?? null;

        $imageConstrains = [
            new Image([
                'maxSize' => '2M',
                'minWidth' => 480,
                'minHeight'=> 300,
                'allowLandscape' => true,
                'allowPortrait' => false,
                'allowSquare' => false
            ]),
        ];

        if (! $article || ! $article->getImageFileName()) {
            $imageConstrains[] = new NotNull([
                'message' => 'Не выбрано изображение статьи'
            ]);
        }

        $builder
            ->add('image', FileType::class, [
                'mapped' => false,
                'label' => 'Изображение статьи',
                'attr' => [
                    'placeholder' => 'Изображение статьи'
                ],
                'required' => false,
                'constraints' => $imageConstrains,
            ])
            ->add('title', TextType::class, [
                'label' => 'Название статьи',
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Описание статьи',
                'attr' => ['rows' => 3],
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Содержимое статьи',
                'attr' => ['rows' => 10],
            ])
            ->add('publishedAt', DateType::class, [
                'label' => 'Дата публикации статьи'
            ])
            ->add('keywords', TextType::class, [
                'label' => 'Ключевые слова статьи'
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstName',
                'label' => 'Автор статьи',
                'placeholder' => 'Выберите автора статьи',
                'choices' => $this->userRepository->findAllSortedByName(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
