<?php

// use PHPUnit\Framework\TestCase;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\Persistence\ManagerRegistry;
// use Doctrine\ORM\Query;
// use Doctrine\ORM\QueryBuilder;
// use Doctrine\ORM\Mapping\ClassMetadata;
// use App\Repository\AlbumRepository;
// use App\Entity\Artist;
// use App\Entity\Album;

// class AlbumRepositoryTest extends TestCase
// {
//     public function testFindByArtist() {
//         $artist = $this->createMock(Artist::class);

//         $queryBuilder = $this->getMockBuilder(QueryBuilder::class)
//             ->disableOriginalConstructor()
//             ->getMock();

//         $queryBuilder->expects($this->at(0))
//             ->method('andWhere')
//             ->with(':artists MEMBER OF al.artists')
//             ->willReturnSelf();
//             var_dump('Called andWhere with :artists MEMBER OF al.artists');
//         $queryBuilder->expects($this->at(1))
//             ->method('andWhere')
//             ->with('al.valid = :valid')
//             ->willReturnSelf();
//             var_dump('Called andWhere with al.valid = :valid');
//         $queryBuilder->expects($this->at(2))
//             ->method('setParameter')
//             ->with('artists', $artist)
//             ->willReturnSelf();
//             var_dump('setParameter artists');
//         $queryBuilder->expects($this->at(3))
//             ->method('setParameter')
//             ->with('valid', 1)
//             ->willReturnSelf();
//             var_dump('setParameter valid');
//         $queryBuilder->expects($this->once())
//             ->method('getQuery')
//             ->willReturn($this->createMock(Query::class)); 

//         $expectedResult = [];

//         $entityManager = $this->createMock(EntityManagerInterface::class);
//         $entityManager->method('createQueryBuilder')
//             ->willReturn($queryBuilder);

//         $classMetadata = new ClassMetadata(Album::class);
//         $classMetadata->name = Album::class; 
//         $entityManager->method('getClassMetadata')
//             ->willReturn($classMetadata);

//         $registry = $this->createMock(ManagerRegistry::class);
//         $registry->method('getManagerForClass')
//             ->willReturn($entityManager);

//         $repository = new AlbumRepository($registry);

//         $result = $repository->findByArtist($artist);
//         $this->assertEquals($expectedResult, $result);
//     }
// }

