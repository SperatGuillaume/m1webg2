<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 5; $i++){
            $category = new Category();
            $category->setName("catégorie$i");

            // créer une référence pour mettre en relation les entités : mise en mémoire de l'instance


            $randomArtwork = random_int(0, 4);
            $category->addArtwork( $this->getReference("artwork$randomArtwork") );

            $manager->persist($category);
        }

        $manager->flush();
    }
}
