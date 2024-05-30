<?php

namespace App\Repository;

use App\Entity\Artist;
use App\Entity\Song;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CountryRepository;

/**
 * @extends ServiceEntityRepository<Artist>
 *
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    public function findBySong(Song $song) : array {
        return $this->createQueryBuilder('a')
           ->andWhere(':songs MEMBER OF a.songs')
           ->andWhere('a.valid = :valid')
           ->setParameter('songs', $song)
           ->setParameter('valid', 1)
           ->getQuery()
           ->getResult()
       ;
    }

    public function findByPartialName(string $name) : array {
        return $this->createQueryBuilder('a')
           ->where('a.name LIKE :name')
           ->andWhere('a.valid = :valid')
           ->setParameter('name', '%'.$name.'%')
           ->setParameter('valid', 1)
           ->getQuery()
           ->getResult()
       ;
    }

    public function findByValid() : array {
        return $this->createQueryBuilder('a')
           ->where('a.valid = :valid')
           ->setParameter('valid', 1)
           ->orderBy('a.name', 'ASC')
           ->getQuery()
           ->getResult()
       ;
    }

    public function findByNotValid() : array {
        return $this->createQueryBuilder('a')
           ->where('a.valid = :valid')
           ->setParameter('valid', 0)
           ->getQuery()
           ->getResult()
       ;
    }

    public function deleteArtist(Artist $artist) : void {
        $idArtist = $artist->getId();
        $conn = $this->getEntityManager()->getConnection();
        $query = $conn->prepare('SELECT * FROM your_table WHERE your_condition = :condition');
        $parameters = [
            'id' => $idUser
            ];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);
    }

    // public function findAll() : array {
    //     $entityManager = $this->getEntityManager();
    //     $query = $entityManager->createQuery(
    //         'SELECT a
    //         FROM App\Entity\Artist a'
    //     );
    //     return $query->getResult();
    // }

    // public function findById(int $idArtist) : ?Artist {
    //     $entityManager = $this->getEntityManager();
    //     $query = $entityManager->createQuery(
    //         'SELECT a
    //         FROM App\Entity\Artist a
    //         WHERE a.id = :idArtist'
    //     )->setParameter('idArtist', $idArtist);
    //     $result = $query->getResult();
    //     if($result) {
    //         $item = $result[0];
    //         $artist = new Artist($item->getId(), $item->getName(), $item->getDescription(), $item->getBirthDate(), $item->getDeathDate(), $item->getIdCountry(), $item->getIdMedia(), $item->isDead());
    //         // print_r($artist);
    //         return $artist;
    //     }
    //     return null;
    // }
    //    /**
    //     * @return Artist[] Returns an array of Artist objects
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

    //    public function findOneBySomeField($value): ?Artist
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
