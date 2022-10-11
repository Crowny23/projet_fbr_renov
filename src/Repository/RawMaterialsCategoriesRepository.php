<?php

namespace App\Repository;

use App\Entity\RawMaterialsCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RawMaterialsCategories>
 *
 * @method RawMaterialsCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method RawMaterialsCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method RawMaterialsCategories[]    findAll()
 * @method RawMaterialsCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RawMaterialsCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RawMaterialsCategories::class);
    }

    public function save(RawMaterialsCategories $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RawMaterialsCategories $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RawMaterialsCategories[] Returns an array of RawMaterialsCategories objects
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

//    public function findOneBySomeField($value): ?RawMaterialsCategories
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
