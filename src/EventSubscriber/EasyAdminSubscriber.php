<?php

namespace App\EventSubscriber;

use App\Entity\Projet;
use App\Repository\UserRepository;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;


class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;
    private $user;
    private $security;

    public function __construct(SluggerInterface $slugger, Security $security, UserRepository $user)
    {
        $this->slugger = $slugger;
        $this->security = $security;
        $this->user = $user;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setDateAndUser']
        ];
    }

    public function setDateAndUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (($entity instanceof Projet)) {
            $now = new DateTime('now');
            $entity->setCreatedAt($now);

            $user = $this->security->getUser();
            $entity->setUser($user);
        }
    }
}