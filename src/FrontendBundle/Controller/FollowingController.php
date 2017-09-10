<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\Following;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class FollowingController extends Controller
{
    public function __construct()
    {
        $this->session = new Session();
    }

    public function followingAction(Request $request)
    {
        $user = $this->getUser();
        $followed_id = $request->get('followed');

        $em = $this->getDoctrine()->getEntityManager();
        $user_repo = $em->getRepository('BackendBundle:User');
        $followed = $user_repo->find($followed_id);

        $following = new Following();
        $following->setUser($user);
        $following->setFollowed($followed);

        $em->persist($following);
        $flush = $em->flush();

        if ($flush == null) {
            $status = 'Se ha registrado correctamente!';
        } else {
            $status = 'No se ha registrado correctamente';
        };
        
        return new Response($status);
    }
}
