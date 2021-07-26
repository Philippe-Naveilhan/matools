<?php

namespace App\Repository;

use App\Entity\Competencestudent;
use App\Entity\Evalcompetence;
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
            ->Where('c.evalcompetence = :evalcompetence')
            ->andWhere('c.note IS NULL')
            ->andWhere('c.comment = :empty')
            ->setParameter('evalcompetence', $evalcompetence)
            ->setParameter('empty', $vide)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Competencestudent[] Returns an array of Competencestudent objects
     */
    public function countAll($evalcompetence)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT count(id) FROM competencestudent AS c WHERE c.evalcompetence_id = :ec';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['ec' => $evalcompetence]);

        // returns number of tuples for this  evalcompetence
        return $stmt->fetchOne();
    }
}
