<?php

namespace App\Repository;

use App\Entity\Evalcategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evalcategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evalcategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evalcategory[]    findAll()
 * @method Evalcategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvalcategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evalcategory::class);
    }

    // /**
    //  * @return Evalcategory[] Returns an array of Evalcategory objects
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
    public function findOneBySomeField($value): ?Evalcategory
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
