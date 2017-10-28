<?php

namespace BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getFollowingUsers($user)
    {
        $em = $this->getEntityManager();
        $following_repo = $em->getRepository('BackendBundle:Following');
        $following = $following_repo->findBy([
            'user' => $user
        ]);

        $following_array = [];
        foreach ($following as $follow) {
            $following_array[] = $follow->getFollowed();
        }

        $user_repo = $em->getRepository('BackendBundle:User');
        $users = $user_repo->createQueryBuilder('u')
            ->where('u.id != :userId AND u.id IN (:following)')
            ->setParameter('userId', $user->getId())
            ->setParameter('following', $following_array)
            ->orderBy('u.id', 'DESC');

        return $users;
    }
}
