<?php

namespace App\Repository;

use App\Entity\RawMaterialsOrdered;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RawMaterialsOrdered>
 *
 * @method RawMaterialsOrdered|null find($id, $lockMode = null, $lockVersion = null)
 * @method RawMaterialsOrdered|null findOneBy(array $criteria, array $orderBy = null)
 * @method RawMaterialsOrdered[]    findAll()
 * @method RawMaterialsOrdered[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RawMaterialsOrderedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RawMaterialsOrdered::class);
    }

    public function save(RawMaterialsOrdered $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RawMaterialsOrdered $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RawMaterialsOrdered[] Returns an array of RawMaterialsOrdered objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RawMaterialsOrdered
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
