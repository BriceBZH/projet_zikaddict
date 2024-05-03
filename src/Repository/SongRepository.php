<?php

namespace App\Repository;

use App\Entity\Song;
use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Song>
 *
 * @method Song|null find($id, $lockMode = null, $lockVersion = null)
 * @method Song|null findOneBy(array $criteria, array $orderBy = null)
 * @method Song[]    findAll()
 * @method Song[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Song::class);
    }


    public function findByAlbum(Album $album) : array {
        return $this->createQueryBuilder('s')
            ->andWhere(':albums MEMBER OF s.albums')
            ->andWhere('s.valid = :valid')
            ->setParameter('albums', $album)
            ->setParameter('valid', 1)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByPartialTitle(string $title) : array {
        return $this->createQueryBuilder('s')
           ->where('s.title LIKE :title')
           ->andWhere('s.valid = :valid')
           ->setParameter('title', '%'.$title.'%')
           ->setParameter('valid', 1)
           ->getQuery()
           ->getResult()
       ;
    }

    public function findByNotValid() : array {
        return $this->createQueryBuilder('s')
           ->where('s.valid = :valid')
           ->setParameter('valid', 0)
           ->getQuery()
           ->getResult()
       ;
    }
    //    /**
    //     * @return Song[] Returns an array of Song objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Song
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
