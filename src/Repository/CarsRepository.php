<?php

namespace App\Repository;

use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
    public function __construct(ManagerRegistry $registry, public EntityManagerInterface $entityManager)
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

    public function findCarsPaginated(int $page, int $limit = 5): array
    {
        $result = [];
        $query = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from('App:Cars', 'c')
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit)
        ;

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        if (empty($data)) {
           return $result;
        }

        // calcul du nombre de pages
        $pages = ceil($paginator->count() / $limit);

        // On remplit le tableau
        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
        $result['count'] = $paginator->count();
        return $result;
    }

    /**
    //     * @return Cars[] Returns an array of Cars objects
    //     */
    public function findByFilters($value, int $page, int $limit = 5): array
    {
        $result = [];
        $query = $this->createQueryBuilder('c')
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
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit)
        ;

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        // calcul du nombre de pages
        $pages = ceil($paginator->count() / $limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
        $result['count'] = $paginator->count();
        return $result;
    }


//    /**
//     * @return Cars[] Returns an array of Cars objects
//     */
//    public function findByExampleField($value)
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.price = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

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
