<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\PrivateMessage;
use FrontendBundle\Form\PrivateMessageType;
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
        $user = $this->getUser();

        $privateMessage = new PrivateMessage();
        $form = $this->createForm(PrivateMessageType::class, $privateMessage, [
            'empty_data' => $user
        ]);

        return $this->render('FrontendBundle:PrivateMessage:index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
