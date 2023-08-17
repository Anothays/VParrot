<?php

namespace App\EventSubscriber;

use App\Entity\Car;
use App\Entity\Garage;
use App\Entity\Schedule;
use App\Entity\Service;
use App\Entity\Testimonial;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class EasyAdminSubscriber implements EventSubscriberInterface
{

    public function __construct(private Security $security, private UserPasswordHasherInterface $userPasswordHasher, private ParameterBagInterface $parameterBag, private EntityManagerInterface $entityManager){}

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => ['beforeUpdateEntity'],
            BeforeEntityPersistedEvent::class => ['beforeCreateEntity'],
            AfterEntityDeletedEvent::class => ['deleteEntityMediaFolder'],
        ];
    }

    public function beforeUpdateEntity(BeforeEntityUpdatedEvent $event)
    {
        $instance = $event->getEntityInstance();
        $currentUser = $this->security->getUser();

        switch (get_class($instance)) {
            case Testimonial::class :
                $instance->getIsApproved() ? $instance->setApprovedBy($currentUser) : $instance->setApprovedBy(null);
                break;
            default :
                break;
        }
    }

    public function beforeCreateEntity(BeforeEntityPersistedEvent $event) {
        $instance = $event->getEntityInstance();
        $currentUser = $this->security->getUser();

        switch (get_class($instance)) {
            case Testimonial::class :
                $instance->setCreatedBy($currentUser);
                $instance->getIsApproved() ? $instance->setApprovedBy($currentUser) : $instance->setApprovedBy(null);
                break;
            case User::class :
                $hash = $this->userPasswordHasher->hashPassword($instance, $instance->getPassword()); // On hash le mot de passe avant de persister
                $instance->setPassword($hash);
                break;
            case Service::class :
                $instance->setCreatedBy($currentUser);
                break;
            case Garage::class :
                $schedule = $this->entityManager->getRepository(Schedule::class)->find(1);
                $instance->setSchedule($schedule); // Tous les nouveaux établissements crées ont les mêmes horaires
                break;
            default :
                break;
        }

    }

    public function deleteEntityMediaFolder(AfterEntityDeletedEvent $event) {
        $instance = $event->getEntityInstance();
        switch (get_class($instance)) {
            case Car::class :

                $mediaFolder = $this->parameterBag->get('public_media_photos');
                $carPhotoFolder = $instance->getLicensePlate();
                if (is_dir($mediaFolder.'/'.$carPhotoFolder)) {
                    rmdir($mediaFolder.'/'.$carPhotoFolder);
                }
                break;
            default :
                break;
        }
    }

}