<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, public EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Car::class);
    }

    public function save(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
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
            ->from('App:Car', 'c')
            ->where('c.published = 1')
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

    public function findByFilters($value, int $page, int $limit = 5): array
    {
        $result = [];
        $query = $this->createQueryBuilder('c')
            ->where('c.published = 1')
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

    public function getMinMaxValues() {
        return $this
                    ->createQueryBuilder('m')
                    ->select('MAX(m.mileage) as maxMileage, Min(m.mileage) as minMileage, MAX(m.price) as maxPrice, Min(m.price) as minPrice, MAX(m.registrationYear) as maxYear, MIN(m.registrationYear) as minYear')
                    ->getQuery()
                    ->getResult();
    }

}
