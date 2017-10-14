<?php

namespace FrontendBundle\Services;

use BackendBundle\Entity\Notification;
use Doctrine\ORM\EntityManager;

class NotificationService
{
    /** @var EntityManager  */
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function set($user, $type, $id, $extra = null)
    {
        $notification = new Notification();
        $notification->setUser($user);
        $notification->setType($type);
        $notification->setTypeId($id);
        $notification->setReaded(0);
        $notification->setCreatedAt(new \DateTime('now'));
        $notification->setExtra($extra);

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->manager;
        $em->persist($notification);
        $flush = $em->flush();

        if ($flush == null) {
            $status = true;
        } else {
            $status = false;
        }

        return $status;
    }

    public function read($user)
    {
        $notification_repo = $this->manager->getRepository('BackendBundle:Notification');
        $notifications = $notification_repo->findBy(['user' => $user]);

        foreach ($notifications as $notification) {
            $notification->setReaded(1);

            $em = $this->manager;
            $em->persist($notification);
        }
        $em->flush();

        return true;
    }
}