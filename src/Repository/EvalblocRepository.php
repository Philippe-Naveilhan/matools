<?php

namespace App\Repository;

use App\Entity\Evalbloc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evalbloc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evalbloc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evalbloc[]    findAll()
 * @method Evalbloc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvalblocRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evalbloc::class);
    }

    // /**
    //  * @return Evalbloc[] Returns an array of Evalbloc objects
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
    public function findOneBySomeField($value): ?Evalbloc
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
