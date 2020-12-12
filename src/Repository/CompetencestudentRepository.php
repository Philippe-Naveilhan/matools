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

     /**
      * @return Competencestudent[] Returns an array of Competencestudent objects
      */
    public function findByEmpty($evalcompetence)
    {
        $vide = "";
        return $this->createQueryBuilder('c')
            ->Where('c.evalcompetence = :val')
            ->andWhere('c.note IS NULL')
            ->andWhere('c.comment = :vide')
            ->setParameter('val', $evalcompetence)
            ->setParameter('vide', $vide)
            ->getQuery()
            ->getResult()
        ;
    }

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
