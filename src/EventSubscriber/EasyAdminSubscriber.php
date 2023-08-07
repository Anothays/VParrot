<?php

namespace App\EventSubscriber;

use App\Entity\Car;
use App\Entity\Photo;
use App\Entity\Service;
use App\Entity\Testimonial;
use App\Entity\User;
use App\Service\ImageService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Vich\UploaderBundle\Event\Event;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isInstanceOf;
use function PHPUnit\Framework\isType;


class EasyAdminSubscriber implements EventSubscriberInterface
{

    private $security;
    private $userPasswordHasher;
    private $parameterBag;

    public function __construct(Security $security, UserPasswordHasherInterface $userPasswordHasher, ParameterBagInterface $parameterBag)
    {

        $this->security = $security;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->parameterBag = $parameterBag;
    }

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
            case User::class :
//                dd($instance);
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
                // Hashing password before persisting
                $hash = $this->userPasswordHasher->hashPassword($instance, $instance->getPassword());
                $instance->setPassword($hash);
                break;
            case Service::class :
                $instance->setUser($currentUser);
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


//    public function createMediaFolder(AfterEntityPersistedEvent $event)
//    {
//
//        $instance = $event->getEntityInstance();
//
//        if ($instance instanceof Car) {
//            $photos = $instance->getPhotos();
//            if (!isEmpty($photos)) {
//                $pathFolder = $this->parameterBag->get("public_media_photos") . '/ref_' . $instance->getReference();
//                if (!is_dir($pathFolder)) {
//                    mkdir($pathFolder, 0777,true);
//                }
//                foreach ($photos as $photo) {
//                    /**
//                     * @var File $file
//                     */
//                    $file = $photo->getFile();
//                    $file->move($pathFolder);
//                    dd($file);
//                }
//            }
//        }
//    }


//   // Fonction appellant le service image qui n'est plus utilisé dans le projet
//    public function cropImage(BeforeEntityPersistedEvent | BeforeEntityUpdatedEvent $event)
//    {
//        $instance = $event->getEntityInstance();
//        if ($instance instanceof Car) {
//            $srcFileName = $instance->getImageName();
//            if($srcFileName) {
//                $file = new File($this->parameterBag->get('resized_images_directory') . '/' . $srcFileName);
//                $image = $this->imageService->add($file);
//                $entity = $event->getEntityInstance();
//                if (!($entity instanceof Car)) {
//                    return;
//                }
//                $entity->setImageName($image);
//            }
//        }
//    }
//
//    public function deleteImage( BeforeEntityDeletedEvent $event)
//    {
//        $instance = $event->getEntityInstance();
//        if ($instance instanceof Car) {
//            $srcFileName = $instance->getimageName();
//            $this->imageService->delete($srcFileName);
//        }
//    }



}