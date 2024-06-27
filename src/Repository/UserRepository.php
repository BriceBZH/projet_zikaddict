<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getPasswordById(int $id): ?string
    {
        return $this->createQueryBuilder('u')
            ->select('u.password')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /* Equals getPasswordById() with PDO
    $query = $this->db->prepare('SELECT users.password FROM users WHERE users.id = :id');
    $parameters = [
        'id' => $id,
    ];
    $query->execute($parameters);
    $songDB = $query->fetch(PDO::FETCH_ASSOC); 
    */
    

}
