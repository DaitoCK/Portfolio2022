<?php

namespace App\EventSubscriber;

use App\Entity\Projet;
Use App\Entity\User;
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

    public function _construct(SluggerInterface $slugger, Security $security, User $user)
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

            $user = $this->$this->security->getUser();
            $entity->setUser($user);


        }

        if (($entity instanceof Blogpost)) {

            $now = new DateTime('now');
            $entity->setCreatedAt($now);

            $user = $this->$this->security->getUser();
            $entity->setUser($user);

        }
        return;
    }
}