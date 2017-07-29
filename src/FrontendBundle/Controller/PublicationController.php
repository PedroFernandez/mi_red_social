<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicationController extends Controller
{
    public function indexAction(Request $request)
    {
        return new Response('WELCOME TO YOUR SOCIAL NETWORK');
    }
}
