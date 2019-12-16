<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Artwork;
use Faker\Factory as Faker;

class DArtworkFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // instancier faker
        $faker = Faker::create('fr_FR');

        // pour remplir la table, créer des objets puis les persister
        for($i = 0; $i < 20; $i++){
            $artwork = new Artwork();
            $artwork
                ->setDescription($faker->text)
                ->setImage($faker->imageUrl(800, 450))
                ->setName($faker->unique()->sentence(5))
            ;

            // récupération d'une référence créée dans CategoryFixtures
            $randomArtwork = random_int(0, 4);
            $artwork->addCategory( $this->getReference("category$randomArtwork") );

            // persist : créer un enregistrement
            $manager->persist($artwork);
        }

        // flush : exécuter les requêtes sql
        $manager->flush();
    }
}
