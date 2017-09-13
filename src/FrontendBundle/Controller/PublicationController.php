<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\Publication;
use BackendBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use FrontendBundle\Form\PublicationType;
use Symfony\Component\HttpFoundation\Session\Session;

class PublicationController extends Controller
{
    /** @var  Session $session */
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->getUser();
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /** @var File $file */
                $file = $form['image']->getData();
                if (!empty($file) && $file != null) {
                    $extension = $file->guessExtension();

                    if ($extension == 'jpg' || $extension == 'jpeg' || $extension = 'png' || $extension || 'gif') {
                        $fileName = $user->getId().time().".".$extension;

                        $file->move("uploads/publications/images", $fileName);

                        $publication->setImage($fileName);
                    } else {
                        $publication->setImage(null);
                    }
                } else {
                    $publication->setImage(null);
                }

                $document = $form['document']->getData();
                if (!empty($file) && $document != null) {
                    $extension = $file->guessExtension();

                    if ($extension == 'pdf') {
                        $documentName = $user->getId().time().".".$extension;
                        $document->move("uploads/publications/documents", $documentName);

                        $publication->setDocument($documentName);
                    } else {
                        $publication->setDocument(null);
                    }
                } else {
                    $publication->setDocument(null);
                }

            } else {
                $status = 'La publicación no se ha creado correctamente';
                $this->session->getFlashBag()->add("error", $status);
            }

            $publication->setUser($user);
            $publication->setCreatedAt(new \DateTime('now'));

            $em->persist($publication);
            $flush = $em->flush();

            if ($flush == null) {
                $status = 'La publicación se ha creado correctamente!';
                $this->session->getFlashBag()->add("success", $status);
            } else {
                $status = 'Error al añadir la publicación :(';
                $this->session->getFlashBag()->add("error", $status);
            }

        return $this->redirectToRoute('home_publications');
        }

        $publications = $this->getPublications($request);

        return $this->render('FrontendBundle:Publication:home.html.twig', [
            'form' => $form->createView(),
            'pagination' => $publications
        ]);
    }

    public function getPublications(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $publications_repo = $em->getRepository('BackendBundle:Publication');
        $following_repo = $em->getRepository('BackendBundle:Following');

        $following = $following_repo->findBy(['user' => $user]);
        $following_array = [];
        foreach ($following as $follow) {
            $following_array[] = $follow->getFollowed();
        }

        $query = $publications_repo->createQueryBuilder('p')
                    ->where('p.user = (:user_id) OR p.user IN (:following)')
                    ->setParameter('user_id', $user->getId())
                    ->setParameter('following', $following_array)
                    ->orderBy('p.id', 'DESC')
                    ->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                    $query,
                    $request->query->getInt('page', 1),
                    5
        );

        return $pagination;
    }
}
