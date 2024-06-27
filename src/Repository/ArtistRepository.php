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

    /* Equals findBySong() with PDO
    $query = $this->db->prepare('SELECT artists.* FROM artists JOIN artist_song ON artists.id = artist_song.artist_id WHERE artist_song.song_id = :songs AND artists.valid = :valid');
    $parameters = [
        'songs' => $song->getId(),
        'valid' => 1
    ];
    $query->execute($parameters);
    $artistDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

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

    /* Equals findByPartialName() with PDO
    $query = $this->db->prepare('SELECT * FROM artists WHERE artists.name LIKE :name AND artists.valid = :valid');
    $parameters = [
        'valid' => 1,
        'name' => '%'.$name.'%'
    ];
    $query->execute($parameters);
    $artistDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

    public function findByValid() : array {
        return $this->createQueryBuilder('a')
           ->where('a.valid = :valid')
           ->setParameter('valid', 1)
           ->orderBy('a.name', 'ASC')
           ->getQuery()
           ->getResult()
       ;
    }

    /* Equals findByValid() with PDO
    $query = $this->db->prepare('SELECT * FROM artists WHERE artists.valid = :valid');
    $parameters = [
        'valid' => 1,
    ];
    $query->execute($parameters);
    $artistDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

    public function findByNotValid() : array {
        return $this->createQueryBuilder('a')
           ->where('a.valid = :valid')
           ->setParameter('valid', 0)
           ->getQuery()
           ->getResult()
       ;
    }

    /* Equals findByNotValid() with PDO
    $query = $this->db->prepare('SELECT * FROM artists WHERE artists.valid = :valid');
    $parameters = [
        'valid' => 0,
    ];
    $query->execute($parameters);
    $artistDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

    public function countByCountry($countryId): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.country = :countryId')
            ->setParameter('countryId', $countryId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /* Equals countByCountry() with PDO
    $query = $this->db->prepare('SELECT count(artists.id) FROM artists WHERE artists.country_id = :countryId');
    $parameters = [
        'countryId' => $countryId,
    ];
    $query->execute($parameters);
    $artistDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

    public function countByMedia($mediaId): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.media = :mediaId')
            ->setParameter('mediaId', $mediaId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /* Equals countByMedia() with PDO
    $query = $this->db->prepare('SELECT count(artists.id) FROM artists WHERE artists.media_id = :mediaId');
    $parameters = [
        'mediaId' => $mediaId,
    ];
    $query->execute($parameters);
    $artistDB = $query->fetch(PDO::FETCH_ASSOC); 
    */
}
