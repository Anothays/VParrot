<?php

namespace App\Repository;

use App\Entity\Testimonials;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Testimonials>
 *
 * @method Testimonials|null find($id, $lockMode = null, $lockVersion = null)
 * @method Testimonials|null findOneBy(array $criteria, array $orderBy = null)
 * @method Testimonials[]    findAll()
 * @method Testimonials[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestimonialsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Testimonials::class);
    }

    public function save(Testimonials $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Testimonials $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Testimonials[] Returns an array of Testimonials objects
     */
    public function findTestimonialsPaginated(int $page, int $limit = 10): array
    {
        $result = [];
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('App:Testimonials', 't')
            ->where('t.validated = 1')
            ->setMaxResults($limit)
            ->orderBy('t.createdAt', 'DESC')
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

//    public function findOneBySomeField($value): ?Testimonials
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
