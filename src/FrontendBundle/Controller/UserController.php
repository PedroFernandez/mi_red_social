<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\User;
use FrontendBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function loginAction(Request $request)
    {
        return $this->render('FrontendBundle:User:login.html.twig', [
            'title' => 'TEST'
        ]);
    }

    public function registerAction(Request $request) {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        return $this->render('FrontendBundle:User:register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
