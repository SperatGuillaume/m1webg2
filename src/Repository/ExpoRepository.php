<?php

namespace App\Repository;

use App\Entity\Expo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Expo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expo[]    findAll()
 * @method Expo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expo::class);
    }



    public function getExpoStillAvailable():Query
    {
        $query = $this->createQueryBuilder('expo')
            ->select('expo.id, expo.name, expo.description, expo.expo_date, expo.slug')
            ->where('expo.expo_date > :today')
            ->setParameter('today', new \DateTime())
            ->getQuery()
        ;
        return $query;
    }

    public function getExpoStillAvailableWithLimit(int $nb_artworks, int $page):Query
    {
        $query = $this->createQueryBuilder('expo')
            ->select('expo.id, expo.name, expo.description, expo.expo_date, expo.slug')
            ->where('expo.expo_date > :today')
            ->setParameter('today', new \DateTime())
            ->setMaxResults($nb_artworks)
            ->setFirstResult($page)
            ->getQuery()
        ;
        return $query;
    }


    // /**
    //  * @return Expo[] Returns an array of Expo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Expo
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
