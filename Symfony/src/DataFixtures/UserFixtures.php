<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $user = (new User())
            ->setEmail('admin@symfony.skillbox')
            ->setFirstName('admin');

        $user
            ->setPassword($this->passwordHasher->hashPassword($user, 'admin'))
            ->setRoles(['ROLE_ADMIN'])
            ->setSubscribeToNewsletter(true);

        $manager->persist(new ApiToken($user));
        $manager->persist($user);

        for ($i = 0; $faker->numberBetween(10, 30) >= $i; $i++) {
            $user = (new User())
                ->setEmail($faker->email)
                ->setFirstName($faker->firstName)
                ->setSubscribeToNewsletter($faker->boolean);

            $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));

            $manager->persist(new ApiToken($user));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
