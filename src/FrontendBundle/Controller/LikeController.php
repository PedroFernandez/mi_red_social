<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\Like;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}