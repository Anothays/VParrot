<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\ContactMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactMessage>
 *
 * @method ContactMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactMessage[]    findAll()
 * @method ContactMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactMessage::class);
    }

    public function save(ContactMessage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ContactMessage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function saveAndUpdateAssociatedCar(ContactMessage $contactMessage, CarRepository | Car $carObject): void
    {
        if ($carObject instanceof CarRepository) {
            // Définition de la regex pour récupérer l'immatriculation
            $regex = '/[A-Z]{2}-\d{3}-[A-Z]{2}/';

            // Recherche de la correspondance dans la chaîne
            preg_match($regex, $contactMessage->getSubject(), $matches);

            // Vérification si une correspondance a été trouvée
            $immatriculation = $matches[0] ?? null;

            $associatedCar = $carObject
                ->createQueryBuilder('c')
                ->select('c')
                ->where('c.licensePlate = :val')
                ->setParameter('val', $immatriculation)
                ->getQuery()
                ->getOneOrNullResult()
            ;
            $contactMessage->setCar($associatedCar);
            $this->save($contactMessage, true);
        } else if ($carObject instanceof Car) {
            $contactMessage->setCar($carObject);
            $this->save($contactMessage, true);
        }
    }

//    public function findOneBySomeField($value): ?ContactMessage
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
