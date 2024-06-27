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
            ->orderBy('s.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /* Equals findByAlbum() with PDO
    $query = $this->db->prepare('SELECT songs.* FROM songs JOIN album_song ON songs.id = album_song.song_id WHERE album_song.album_id = :albums AND songs.valid = :valid ORDER BY songs.title ASC');
    $parameters = [
        'albums' => $album->getId(),
        'valid' => 1
    ];
    $query->execute($parameters);
    $songDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

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

    /* Equals findByPartialName() with PDO
    $query = $this->db->prepare('SELECT * FROM songs WHERE songs.title LIKE :title AND songs.valid = :valid');
    $parameters = [
        'valid' => 1,
        'title' => '%'.$title.'%'
    ];
    $query->execute($parameters);
    $songDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

    public function findByNotValid() : array {
        return $this->createQueryBuilder('s')
           ->where('s.valid = :valid')
           ->setParameter('valid', 0)
           ->getQuery()
           ->getResult()
       ;
    }

    /* Equals findByNotValid() with PDO
    $query = $this->db->prepare('SELECT * FROM songs WHERE songs.valid = :valid');
    $parameters = [
        'valid' => 0,
    ];
    $query->execute($parameters);
    $songDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

    public function findByValid() : array {
        return $this->createQueryBuilder('s')
           ->where('s.valid = :valid')
           ->setParameter('valid', 1)
           ->getQuery()
           ->getResult()
       ;
    }

    /* Equals findByValid() with PDO
    $query = $this->db->prepare('SELECT * FROM songs WHERE songs.valid = :valid');
    $parameters = [
        'valid' => 1,
    ];
    $query->execute($parameters);
    $songDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

    public function countByGenre($genreId): int
    {
        return $this->createQueryBuilder('s')
            ->select('count(s.id)')
            ->where('s.genre = :genreId')
            ->setParameter('genreId', $genreId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /* Equals countByGenre() with PDO
    $query = $this->db->prepare('SELECT count(songs.id) FROM songs WHERE songs.genre_id = :genreId');
    $parameters = [
        'genreId' => $genreId,
    ];
    $query->execute($parameters);
    $songDB = $query->fetch(PDO::FETCH_ASSOC); 
    */
}
