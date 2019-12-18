<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private  $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setEmail('tito.salgado@gmail.com')
            ->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,'123456'
                )
            )
        ;

        $user->addRole( $this->getReference('ROLE_ADMIN') );

        // persist : créer un enregistrement
        $manager->persist($user);
        // flush : exécuter les requêtes sql
        $manager->flush();
    }
}
