<?php

namespace App\Repository;

use App\Entity\BetUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BetUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method BetUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method BetUser[]    findAll()
 * @method BetUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BetUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BetUser::class);
    }

    // /**
    //  * @return BetUser[] Returns an array of BetUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BetUser
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
