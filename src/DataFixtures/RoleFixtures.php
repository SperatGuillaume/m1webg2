<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


        $role1 = new Role();
        $role1->setName('ROLE_USER');
        $this->addReference('ROLE_USER',$role1);

        $manager->persist($role1);


        $role2 = new Role();
        $role2->setName('ROLE_ADMIN');
        $this->addReference('ROLE_ADMIN',$role2);

        $manager->persist($role2);


        $manager->flush();
    }
}
