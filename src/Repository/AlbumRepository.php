<?php

namespace App\Repository;

use App\Entity\Artist;
use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Album>
 *
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    public function findByArtist(Artist $artist) : array {
        $result = $this->createQueryBuilder('al')
            ->andWhere(':artists MEMBER OF al.artists')
            ->andWhere('al.valid = :valid')
            ->setParameter('artists', $artist)
            ->setParameter('valid', 1)
            ->getQuery()
            ->getResult();

        return $result ?: [];
    }

    public function findByPartialTitle(string $title) : array {
        $result = $this->createQueryBuilder('a')
           ->where('a.title LIKE :title')
           ->andWhere('a.valid = :valid')
           ->setParameter('title', '%'.$title.'%')
           ->setParameter('valid', 1)
           ->getQuery()
           ->getResult();

        return $result ?: [];
    }

    public function findByValid() : array {
        $result = $this->createQueryBuilder('a')
           ->where('a.valid = :valid')
           ->setParameter('valid', 1)
           ->getQuery()
           ->getResult();

        return $result ?: [];
    }

    public function findByNotValid() : array {
        $result = $this->createQueryBuilder('a')
           ->where('a.valid = :valid')
           ->setParameter('valid', 0)
           ->getQuery()
           ->getResult();

        return $result ?: [];
    }
    //    /**
    //     * @return Album[] Returns an array of Album objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Album
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
