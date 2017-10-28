<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class PrivateMessageController extends Controller
{
    /** @var Session $session */
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function indexAction(Request $request)
    {
        return $this->render('FrontendBundle:PrivateMessage:index.html.twig', [
            'titulo' => 'Hello Peter!'
        ]);
    }
}
