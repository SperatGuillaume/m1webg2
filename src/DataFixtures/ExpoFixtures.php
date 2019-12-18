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
        for($i = 0; $i < 20; $i++){
            $expo = new Expo();
            $expo
                ->setDescription($faker->text)
                ->setExpoDate($faker->dateTimeThisMonth)
                ->setName($faker->unique()->sentence(5))
            ;



            // persist : créer un enregistrement
            $manager->persist($expo);
        }


        for($i = 0; $i < 20; $i++){
            $expo = new Expo();
            $expo
                ->setDescription($faker->text)
                ->setExpoDate(\DateTime::createFromFormat("Y-m-d H:i:s", '2020-02-03 07:14:10'))
                ->setName($faker->unique()->sentence(5))
            ;



            // persist : créer un enregistrement
            $manager->persist($expo);
        }

        // flush : exécuter les requêtes sql
        $manager->flush();
    }
}
