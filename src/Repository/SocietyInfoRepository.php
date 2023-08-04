<?php

namespace App\Repository;

use App\Entity\SocietyInformations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SocietyInformations>
 *
 * @method SocietyInformations|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocietyInformations|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocietyInformations[]    findAll()
 * @method SocietyInformations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocietyInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocietyInformations::class);
    }

    public function save(SocietyInformations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SocietyInformations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
