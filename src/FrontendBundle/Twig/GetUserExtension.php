<?php

namespace FrontendBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;

class GetUserExtension extends \Twig_Extension
{
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('get_user', [$this, 'getUserFilter'])
        ];
    }

    public function getUserFilter($userID)
    {
        $user_repo = $this->doctrine->getRepository('BackendBundle:User');

        $user = $user_repo->findOneBy(['id' => $userID]);

        return $user;
    }

    public function getName()
    {
        return 'get_user_extension';
    }
}