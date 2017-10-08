<?php

namespace FrontendBundle\Services;

use BackendBundle\Entity\Notification;

class NotificationService
{
    private $manager;

    public function __construct($manager)
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
}