<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\Like;
use FrontendBundle\Services\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function likeAction($id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $publication_repo = $em->getRepository('BackendBundle:Publication');

        $publication = $publication_repo->find($id);

        $like = (new Like())
            ->setUser($user)
            ->setPublication($publication);

        $em->persist($like);
        $flush = $em->flush();

        if ($flush == null) {
            /** @var NotificationService $notification */
            $notification = $this->get('app.notification_service');
            $notification->set($publication->getUser(), 'like', $user->getId(), $publication->getId());

            $status = 'Te gusta esta publicación :) ';
        } else {
            $status = 'Error al guardar el Me gusta :(';
        }

        return new Response($status);
    }

    public function unlikeAction($id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $like_repo = $em->getRepository('BackendBundle:Like');

        $like = $like_repo->findOneBy([
                'user' => $user,
                'publication' => $id
            ]);

        $em->remove($like);
        $flush = $em->flush();

        if ($flush == null) {
            $status = 'Ya no te gusta esta publicación';
        } else {
            $status = 'Error al desmarcar el Me gusta';
        }

        return new Response($status);
    }

    public function likesAction(Request $request, $nickname = null)
    {
        $em = $this->getDoctrine()->getManager();

        if ($nickname != null) {
            $user_repo = $em->getRepository('BackendBundle:User');
            $user = $user_repo->findOneBy(['nick' => $nickname]);
        } else {
            $user = $this->getUser();
        }

        if (empty($user) || !is_object($user)) {
            return $this->redirect($this->generateUrl('home_publications'));
        }

        $user_id = $user->getId();
        $dql = "SELECT l FROM BackendBundle:Like l WHERE l.user = $user_id ORDER BY l.id DESC";

        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $likes = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), 5
        );

        return $this->render('FrontendBundle:Likes:likes.html.twig', [
            'user' => $user,
            'pagination' => $likes
        ]);
    }
}