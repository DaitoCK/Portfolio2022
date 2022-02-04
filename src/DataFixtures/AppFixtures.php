<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Projet;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {
        // Utilisation de faker
        $faker = Factory::create('fr-FR');

        // Création user
        $user = new User();

        $user->setEmail('user@test.com')
            ->setNom($faker->lastName())
            ->setPrenom($faker->firstName());


        $password = $this->encoder->hashPassword($user, '123456');
        $user->setPassword($password);

        $manager->persist($user);

        // Création 3 catégories
        for ($k=0; $k < 5; $k++) {
            $categorie = new Categorie();

            $categorie->setNom($faker->word())
                    ->setDescription($faker->words(10, true))
                    ->setSlug($faker->slug());

            $manager->persist($categorie);


            // Création de 2 projet par catégorie
            for ($j=0; $j < 2; $j++) {
                $projet = new Projet();

                $projet->setNom($faker->words(3, true))
                    ->setDateRealisation($faker->dateTimeBetween('-6 month', 'now'))
                    ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                    ->setDescription($faker->text())
                    ->setPortfolio($faker->randomElement([true, false]))
                    ->setSlug($faker->slug())
                    ->setFile('hero-bg.jpg')
                    ->addCategorie($categorie)
                    ->setUser($user);

                $manager->persist($projet);
            }
        }
        $manager->flush();
    }
}
