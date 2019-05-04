<?php

namespace AceUser\Entity\Subscriber;

use AceUser\Entity\User;
use AceUser\Service\UserService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class PasswordSubscriber implements EventSubscriber
{
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof User) {
            if (!$entity->getPassword()) {
                $userService = new UserService(); // TODO get UserService from service manager
                $entity->setPassword($userService->generatePassword());
            }
        }
    }
}