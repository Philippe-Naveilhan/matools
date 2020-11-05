<?php

namespace App\Repository;

use App\Entity\Competencestudent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Competencestudent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competencestudent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competencestudent[]    findAll()
 * @method Competencestudent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetencestudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competencestudent::class);
    }

    // /**
    //  * @return Competencestudent[] Returns an array of Competencestudent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Competencestudent
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
