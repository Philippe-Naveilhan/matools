<?php

namespace App\Repository;

use App\Entity\Evalstudent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evalstudent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evalstudent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evalstudent[]    findAll()
 * @method Evalstudent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvalstudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evalstudent::class);
    }

    // /**
    //  * @return Evalstudent[] Returns an array of Evalstudent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Evalstudent
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
