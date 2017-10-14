<?php

namespace FrontendBundle\Controller;

use FrontendBundle\Services\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class NotificationController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $userId = $user->getId();

        $dql = "SELECT n FROM BackendBundle:Notification n WHERE n.user = $userId ORDER BY n.id DESC";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $publications = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), 5
        );

        /** @var NotificationService $notification */
        $notification = $this->get('app.notification_service');
        $notification->read($user);

        return $this->render('FrontendBundle:Notification:notification_page.html.twig', [
            'user' => $user,
            'pagination' => $publications
        ]);
    }

    public function countNotificationsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $notification_repo = $em->getRepository('BackendBundle:Notification');

        $notifications = $notification_repo->findBy([
            'user' => $this->getUser(),
            'readed' => 0
        ]);

        return new Response(count($notifications));
    }
}
