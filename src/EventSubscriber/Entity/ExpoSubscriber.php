<?php

namespace App\EventSubscriber\Entity;

use App\Entity\Expo;
use App\Service\FileService;
use App\Service\StringService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Console\Event\ConsoleErrorEvent;

class ExpoSubscriber implements EventSubscriber
{

    private $stringService;
    private $fileService;

    public function __construct(StringService $stringService, FileService $fileService)
    {
        $this->stringService = $stringService;
        $this->fileService = $fileService;
    }


    public function prePersist(LifecycleEventArgs $args):void
    {
        // par défaut, les souscripteurs écoutent toutes les entités
        $entity = $args->getObject();

        if(!$entity instanceof Expo){
            return;
        } else {
            // création du slug
            $name = $entity->getName();
            $slug = $this->stringService->getSlug($name);
            $entity->setSlug($slug);
        }
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist
        ];
    }

}
