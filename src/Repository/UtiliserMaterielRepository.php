<?php

namespace App\Repository;

use App\Entity\UtiliserMateriel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UtiliserMateriel>
 *
 * @method UtiliserMateriel|null find($id, $lockMode = null, $lockVersion = null)
 * @method UtiliserMateriel|null findOneBy(array $criteria, array $orderBy = null)
 * @method UtiliserMateriel[]    findAll()
 * @method UtiliserMateriel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtiliserMaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UtiliserMateriel::class);
    }

//    /**
//     * @return UtiliserMateriel[] Returns an array of UtiliserMateriel objects
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

//    public function findOneBySomeField($value): ?UtiliserMateriel
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
