<?php

namespace App\Repository;

use App\Entity\Artwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Artwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artwork[]    findAll()
 * @method Artwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artwork::class);
    }

    public function getArtworkByCategoryId(int $id):Query
    {
        $query = $this->createQueryBuilder('artwork')
            ->select('artwork.id, artwork.name, artwork.description, artwork.image, artwork.slug')
            ->join('artwork.categories', 'categories')
            ->where('categories.id = :id')
            ->setParameters([
                'id' => $id
            ])

            ->getQuery()
        ;
        return $query;
    }

    public function getArtworkByCategoryIdWithLimit(int $id, int $nb_artworks, int $page):Query
    {
        $query = $this->createQueryBuilder('artwork')
            ->select('artwork.id, artwork.name, artwork.description, artwork.image, artwork.slug')
            ->join('artwork.categories', 'categories')
            ->where('categories.id = :id')
            ->setParameters([
                'id' => $id
            ])
            ->setMaxResults($nb_artworks)
            ->setFirstResult($page)

            ->getQuery()
        ;
        return $query;
    }

    // /**
    //  * @return Artwork[] Returns an array of Artwork objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Artwork
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
