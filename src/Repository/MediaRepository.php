<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Media>
 *
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    public function findByNotUpload() : array {
        $result = $this->createQueryBuilder('m')
           ->where('m.urlSource != :upload')
           ->setParameter('upload', "Upload")
           ->getQuery()
           ->getResult();

        return $result ?: [];
    }

    /* Equals findByNotUpload() with PDO
    $query = $this->db->prepare('SELECT * FROM medias WHERE medias.url_source != :upload');
    $parameters = [
        'upload' => "Upload",
    ];
    $query->execute($parameters);
    $mediaDB = $query->fetch(PDO::FETCH_ASSOC); 
    */
}
