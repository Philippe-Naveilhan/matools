<?php

namespace App\Repository;

use App\Entity\Evalcompetence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evalcompetence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evalcompetence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evalcompetence[]    findAll()
 * @method Evalcompetence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvalcompetenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evalcompetence::class);
    }

     /**
      * @return Evalcompetence[] Returns an array of Evalcompetence objects
      */

    public function findByEvaluation($evaluation)
    {
        $quest = $this->createQueryBuilder('evalcompetence')
            ->innerJoin('evalcompetence.bloc', 'evalbloc')
            ->innerJoin('evalbloc.category', 'evalcategory')
            ->innerJoin('evalcategory.theme', 'evaltheme')
            ->where('evalcompetence.evaluation = :eval')
            ->setParameter('eval', $evaluation)
            ->getQuery();

        $result = $quest->execute();

        return $result;
    }


    /*
    public function findOneBySomeField($value): ?Evalcompetence
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
