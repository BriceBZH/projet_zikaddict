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

    /* Equals findByArtist() with PDO
    $query = $this->db->prepare('SELECT albums.* FROM albums JOIN artist_album ON albums.id = artist_album.album_id WHERE artist_album.artist_id = :artists  AND albums.valid = :valid');
    $parameters = [
        'songs' => $song->getId(),
        'valid' => 1
    ];
    $query->execute($parameters);
    $albumDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

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

    /* Equals findByPartialName() with PDO
    $query = $this->db->prepare('SELECT * FROM albums WHERE albums.title LIKE :title AND albums.valid = :valid');
    $parameters = [
        'valid' => 1,
        'title' => '%'.$title.'%'
    ];
    $query->execute($parameters);
    $albumDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

    public function findByValid() : array {
        $result = $this->createQueryBuilder('a')
           ->where('a.valid = :valid')
           ->setParameter('valid', 1)
           ->orderBy('a.title', 'ASC')
           ->getQuery()
           ->getResult();

        return $result ?: [];
    }

    /* Equals findByValid() with PDO
    $query = $this->db->prepare('SELECT * FROM albums WHERE albums.valid = :valid');
    $parameters = [
        'valid' => 1,
    ];
    $query->execute($parameters);
    $albumDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

    public function findByNotValid() : array {
        $result = $this->createQueryBuilder('a')
           ->where('a.valid = :valid')
           ->setParameter('valid', 0)
           ->getQuery()
           ->getResult();

        return $result ?: [];
    }

    /* Equals findByNotValid() with PDO
    $query = $this->db->prepare('SELECT * FROM albums WHERE albums.valid = :valid');
    $parameters = [
        'valid' => 0,
    ];
    $query->execute($parameters);
    $albumDB = $query->fetch(PDO::FETCH_ASSOC);
    */

    public function countByFormat($formatId): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->andWhere(':formats MEMBER OF a.formats')
            ->setParameter('formats', $formatId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /* Equals countByFormat() with PDO
    $query = $this->db->prepare('SELECT count(albums.id) FROM albums JOIN album_format ON albums.id = album_format.album_id WHERE album_format.format_id = :formats');
    $parameters = [
        'formats' => $formatId,
    ];
    $query->execute($parameters);
    $albumDB = $query->fetch(PDO::FETCH_ASSOC);  
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

    /* Equals findBySong() with PDO
    $query = $this->db->prepare('SELECT count(albums.id) FROM albums WHERE albums.media_id = :mediaId');
    $parameters = [
        'mediaId' => $mediaId,
    ];
    $query->execute($parameters);
    $albumDB = $query->fetch(PDO::FETCH_ASSOC);  
    */
}
