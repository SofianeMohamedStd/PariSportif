<?php

namespace App\Repository;

use App\Entity\EvenementSport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvenementSport|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvenementSport|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvenementSport[]    findAll()
 * @method EvenementSport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementSportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvenementSport::class);
    }

    // /**
    //  * @return EvenementSport[] Returns an array of EvenementSport objects
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
    public function findOneBySomeField($value): ?EvenementSport
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
