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

    /* Equals findByUserAlbumFormatType() with PDO
    $query = $this->db->prepare('SELECT * FROM user_album_format 
        WHERE user_album_format.user_id = :user AND user_album_format.album_id = :album
        AND user_album_format.format_id = :format AND user_album_format.type = :type');
    $parameters = [
        'user' => $user,
        'type' => $type,
        'album' => $album,
        'format' => $format,
    ];
    $query->execute($parameters);
    $UserAlbumFormatDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

    public function findByUserCollectionType(User $user, string $type): array {
        return $this->createQueryBuilder('uaf')
            ->innerJoin("uaf.format", 'f')
            ->innerJoin("uaf.album", 'al')
            ->innerJoin("al.artists", 'ar')
            ->andWhere(':user = uaf.user')
            ->andWhere(':type = uaf.type')
            ->setParameter('user', $user)
            ->setParameter('type', $type)
            ->orderBy('f.libelle', 'ASC')
            ->addOrderBy('ar.name', 'ASC')
            ->addOrderBy('al.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /* Equals findByUserCollectionType() with PDO
    $query = $this->db->prepare('SELECT user_album_format.*
        FROM user_album_format
        INNER JOIN formats ON user_album_format.format_id = formats.id
        INNER JOIN albums ON user_album_format .album_id = albums.id
        INNER JOIN artist_album ON albums.id = artist_album.album_id
        INNER JOIN artists ON artist_album.artist_id = artists.id
        WHERE user_album_format.user_id = :user_id
        AND user_album_format.type = :type
        ORDER BY formats.libelle ASC, artists.name ASC, albums.title ASC');
    $parameters = [
        'user' => $user,
        'type' => $type,
    ];
    $query->execute($parameters);
    $UserAlbumFormatDB = $query->fetch(PDO::FETCH_ASSOC); 
    */

}
