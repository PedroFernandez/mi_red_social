<?php

namespace FrontendBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;

class LikedExtension extends \Twig_Extension
{
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('liked', [$this, 'likedFilter'])
        ];
    }

    public function likedFilter($user, $publication)
    {
        $em = $this->doctrine->getManager();
        $like_repo = $em->getRepository('BackendBundle:Like');

        $publication_liked = $like_repo->findOneBy([
            'user' => $user,
            'publication' => $publication
        ]);

        if (!empty($publication_liked) && is_object($publication_liked)) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    public function getName()
    {
        return 'liked_extension';
    }
}