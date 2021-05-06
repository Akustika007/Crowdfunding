<?php

namespace App\Repository;

use App\Entity\Crowdfunding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Crowdfunding|null find($id, $lockMode = null, $lockVersion = null)
 * @method Crowdfunding|null findOneBy(array $criteria, array $orderBy = null)
 * @method Crowdfunding[]    findAll()
 * @method Crowdfunding[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CrowdfundingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Crowdfunding::class);
    }

    // /**
    //  * @return Crowdfunding[] Returns an array of Crowdfunding objects
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
    public function findOneBySomeField($value): ?Crowdfunding
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