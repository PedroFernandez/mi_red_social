<?php

namespace BackendBundle\Controller;

use BackendBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user_repo = $em->getRepository('BackendBundle:User');

        /** @var User $user */
        $user = $user_repo->findAll()[0];

        echo "Welcome Mr: " . $user->getName() . " " . $user->getEmail() . "\n";
die;
        return $this->render('BackendBundle:Default:index.html.twig');
    }
}
