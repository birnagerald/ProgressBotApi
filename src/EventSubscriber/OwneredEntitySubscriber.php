<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Entity\Anime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OwneredEntitySubscriber implements EventSubscriberInterface
{   
    public function __construct(TokenStorageInterface $tokenStorage){
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::VIEW => ['getAuthenticatedUser', EventPriorities::PRE_WRITE]
        ];
    }

    public function getAuthenticatedUser(GetResponseForControllerResultEvent $event)
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        $owner = $this->tokenStorage->getToken()->getUser();

        if (!$entity instanceof Anime || Request::METHOD_POST !== $method){
            return;
        }
        
        $entity->setOwner($owner);
    }
}