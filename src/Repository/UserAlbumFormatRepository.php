<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Album;
use App\Entity\Format;
use App\Entity\UserAlbumFormat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserAlbumFormat>
 *
 * @method UserAlbumFormat|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAlbumFormat|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAlbumFormat[]    findAll()
 * @method UserAlbumFormat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAlbumFormatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAlbumFormat::class);
    }

    public function findByUserAlbumFormatType(User $user, Album $album, Format $format, string $type): array {
        return $this->createQueryBuilder('uaf')
            ->andWhere(':user = uaf.user')
            ->andWhere(':album = uaf.album')
            ->andWhere(':format = uaf.format')
            ->andWhere(':type = uaf.type')
            ->setParameter('user', $user)
            ->setParameter('album', $album)
            ->setParameter('format', $format)
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }

    public function findByUserCollectionType(User $user, string $type): array {
        return $this->createQueryBuilder('uaf')
            ->andWhere(':user = uaf.user')
            ->andWhere(':type = uaf.type')
            ->setParameter('user', $user)
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return UserAlbumFormat[] Returns an array of UserAlbumFormat objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UserAlbumFormat
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
