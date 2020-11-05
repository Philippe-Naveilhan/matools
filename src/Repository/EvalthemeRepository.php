<?php

namespace App\Repository;

use App\Entity\Evaltheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evaltheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evaltheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evaltheme[]    findAll()
 * @method Evaltheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvalthemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evaltheme::class);
    }

    // /**
    //  * @return Evaltheme[] Returns an array of Evaltheme objects
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
    public function findOneBySomeField($value): ?Evaltheme
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
