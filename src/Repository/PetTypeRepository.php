<?php

namespace CoralMedia\Bundle\PetClinicBundle\Repository;

use CoralMedia\Bundle\PetClinicBundle\Entity\PetType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PetType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PetType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PetType[]    findAll()
 * @method PetType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PetType::class);
    }

    // /**
    //  * @return PetType[] Returns an array of PetType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PetType
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}