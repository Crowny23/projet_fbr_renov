<?php

namespace App\Repository;

use App\Entity\RawMaterials;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RawMaterials>
 *
 * @method RawMaterials|null find($id, $lockMode = null, $lockVersion = null)
 * @method RawMaterials|null findOneBy(array $criteria, array $orderBy = null)
 * @method RawMaterials[]    findAll()
 * @method RawMaterials[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RawMaterialsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RawMaterials::class);
    }

    public function save(RawMaterials $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RawMaterials $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return RawMaterials[] Returns an array of RawMaterials objects
    */
    public function findByNameAndCategory($search, $category): array
    {
        if($category === null) {
            return $this->createQueryBuilder('r')
                ->andWhere('r.name_raw_material LIKE :search')
                ->setParameter('search', '%' . $search . '%')
                ->orderBy('r.id', 'ASC')
                ->setMaxResults(50)
                ->getQuery()
                ->getResult()
            ;
        } else if ($search === null) {
            return $this->createQueryBuilder('r')
                ->andWhere('r.category = :cat')
                ->setParameter('cat', $category)
                ->orderBy('r.id', 'ASC')
                ->setMaxResults(50)
                ->getQuery()
                ->getResult()
            ;
        } else {
            return $this->createQueryBuilder('r')
                ->where('r.category = :cat')
                ->setParameter('cat', $category)
                ->andWhere('r.name_raw_material LIKE :search')
                ->setParameter('search', '%' . $search . '%')
                ->orderBy('r.id', 'ASC')
                ->setMaxResults(50)
                ->getQuery()
                ->getResult()
            ;
        }
    }

//    public function findOneBySomeField($value): ?RawMaterials
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
