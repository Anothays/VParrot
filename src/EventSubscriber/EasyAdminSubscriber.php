<?php

namespace App\EventSubscriber;

use App\Entity\Car;
use App\Entity\Photo;
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
use Vich\UploaderBundle\Event\Event;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isInstanceOf;
use function PHPUnit\Framework\isType;


class EasyAdminSubscriber implements EventSubscriberInterface
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => ['beforeUpdateEntity'],
            BeforeEntityPersistedEvent::class => ['afterCreateEntity'],
            AfterEntityDeletedEvent::class => ['deleteEntityMediaFolder'],
        ];
    }

    public function beforeUpdateEntity(BeforeEntityUpdatedEvent $event)
    {
        $instance = $event->getEntityInstance();
        $currentUser = $this->security->getUser();
        $instance instanceof Testimonial ? $instance->getIsApproved() ? $instance->setApprovedBy($currentUser) : $instance->setApprovedBy(null) : null;
    }

    public function afterCreateEntity(BeforeEntityPersistedEvent $event) {
        $instance = $event->getEntityInstance();
        $currentUser = $this->security->getUser();
        if ($instance instanceof Testimonial) {
            $instance->setCreatedBy($currentUser);
            $instance->getIsApproved() ? $instance->setApprovedBy($currentUser) : $instance->setApprovedBy(null);
        }
    }

    public function deleteEntityMediaFolder(AfterEntityDeletedEvent $event) {
        $instance = $event->getEntityInstance();
        if ($instance instanceof Car) {
            $mediaFolder = $this->parameterBag->get('public_media_photos');
            $carPhotoFolder = $instance->getLicensePlate();
            rmdir($mediaFolder.'/'.$carPhotoFolder);
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