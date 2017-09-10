<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        echo 'following';
        die();
    }
}
