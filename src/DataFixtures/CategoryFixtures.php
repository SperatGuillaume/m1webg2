<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories_label = ['peinture','dessin','sculpture'];
        // $product = new Product();
        // $manager->persist($product);

        foreach ($categories_label as $category_label){
            $category = new Category();
            $category->setName($category_label);
            $this->addReference($category_label,$category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
