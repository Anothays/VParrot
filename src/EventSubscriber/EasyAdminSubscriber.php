<?php

namespace App\EventSubscriber;

use App\Entity\Cars;
use App\Entity\User;
use App\Service\ImageService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use function PHPUnit\Framework\isInstanceOf;
use function PHPUnit\Framework\isType;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private ImageService $imageService;
    private ParameterBag $parameterBag;

    public function __construct(ImageService $imageService, ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
        $this->imageService = $imageService;

    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['cropImage'],
            BeforeEntityUpdatedEvent::class => ['cropImage'],
            BeforeEntityDeletedEvent::class => ['deleteImage'],
//            BeforeCrudActionEvent::class => ['test'],
//            AfterCrudActionEvent::class => ['test']
        ];
    }

    public function cropImage(BeforeEntityPersistedEvent | BeforeEntityUpdatedEvent $event)
    {
        $instance = $event->getEntityInstance();
        if ($instance instanceof Cars) {
            $srcFileName = $instance->getImageName();
            if($srcFileName) {
                $file = new File($this->parameterBag->get('resized_images_directory') . '/' . $srcFileName);
                $image = $this->imageService->add($file);
                $entity = $event->getEntityInstance();
                if (!($entity instanceof Cars)) {
                    return;
                }
                $entity->setImageName($image);
            }
        }
    }

    public function deleteImage( BeforeEntityDeletedEvent $event)
    {
        $instance = $event->getEntityInstance();
        if ($instance instanceof Cars) {
            $srcFileName = $instance->getimageName();
            $this->imageService->delete($srcFileName);
        }
    }

    public function test(BeforeCrudActionEvent | AfterCrudActionEvent $event)
    {
//        dd($event->getAdminContext()->getEntity()->getInstance());

//        if($event->getAdminContext()->getEntity()->getInstance()) {
////            $event->getAdminContext()->getEntity()->getInstance()->setImageName('garage 2.jpg');
//        }

    }

}