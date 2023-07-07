<?php

namespace App\Repository;

use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cars>
 *
 * @method Cars|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cars|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cars[]    findAll()
 * @method Cars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cars::class);
    }

    public function save(Cars $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cars $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    //     * @return Cars[] Returns an array of Cars objects
    //     */
    public function findByFilters($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.mileage >= :mileageMin')
            ->andWhere('c.mileage <= :mileageMax')
            ->andWhere('c.price >= :priceMin')
            ->andWhere('c.price <= :priceMax')
            ->andWhere('c.registrationYear >= :yearMin')
            ->andWhere('c.registrationYear <= :yearMax')
            ->setParameter('mileageMin' ,$value["mileageMin"])
            ->setParameter('mileageMax' ,$value["mileageMax"])
            ->setParameter('priceMin' ,$value["priceMin"])
            ->setParameter('priceMax' ,$value["priceMax"])
            ->setParameter('yearMin' ,$value["yearMin"])
            ->setParameter('yearMax' ,$value["yearMax"])
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @return Cars[] Returns an array of Cars objects
     */
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.price = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Cars
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
