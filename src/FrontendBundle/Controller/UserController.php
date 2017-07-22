<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function loginAction(Request $request)
    {
        return $this->render('FrontendBundle:User:login.html.twig', [
            'title' => 'Login'
        ]);
    }
}
