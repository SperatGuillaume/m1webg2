<?php

namespace App\DataFixtures;

use App\Entity\Expo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class ExpoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // instancier faker
        $faker = Faker::create('fr_FR');

        // pour remplir la table, créer des objets puis les persister
        for($i = 0; $i < 5; $i++){
            $expo = new Expo();
            $expo
                ->setDescription($faker->text)
                ->setExpoDate($faker->dateTimeThisYear)
                ->setName($faker->unique()->sentence(5))
            ;



            // persist : créer un enregistrement
            $manager->persist($expo);
        }

        // flush : exécuter les requêtes sql
        $manager->flush();
    }
}
