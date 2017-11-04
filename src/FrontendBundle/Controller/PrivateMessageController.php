<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\PrivateMessage;
use Doctrine\ORM\EntityManager;
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
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $privateMessage = new PrivateMessage();
        $form = $this->createForm(PrivateMessageType::class, $privateMessage, [
            'empty_data' => $user
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $file = $form['image']->getData();
                if (!empty($file) && $file != null) {
                    $extension = $file->guessExtension();

                    if ($extension == 'jpg' || $extension == 'jpeg' || $extension = 'png' || $extension || 'gif') {
                        $fileName = $user->getId() . time() . "." . $extension;

                        $file->move("uploads/messages/images", $fileName);

                        $privateMessage->setImage($fileName);
                    } else {
                        $privateMessage->setImage(null);
                    }
                } else {
                    $privateMessage->setImage(null);
                }

                $document = $form['file']->getData();
                if (!empty($document) && $document != null) {
                    $extension = $document->guessExtension();

                    if ($extension == 'pdf') {
                        $documentName = $user->getId() . time() . "." . $extension;
                        $document->move("uploads/messages/files", $documentName);

                        $privateMessage->setFile($documentName);
                    } else {
                        $privateMessage->setFile(null);
                    }
                } else {
                    $privateMessage->setFile(null);
                }
            } else {
                $status = 'El mensaje no se ha enviado correctamente';
                $this->session->getFlashBag()->add("error", $status);
            }

            $privateMessage->setEmitter($user);
            $privateMessage->setCreatedAt(new \DateTime('now'));
            $privateMessage->setReaded(0);

            $em->persist($privateMessage);
            $flush = $em->flush();

            if ($flush == null) {
                $status = 'La publicación se ha creado correctamente!';
                $this->session->getFlashBag()->add("success", $status);
            } else {
                $status = 'Error al añadir la publicación :(';
                $this->session->getFlashBag()->add("error", $status);
            }

            return $this->redirectToRoute('private_message_index');
        }

        $privateMessages = $this->getPrivateMessages($request);

        return $this->render('FrontendBundle:PrivateMessage:index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $privateMessages
        ]);
    }

    public function sendedAction(Request $request)
    {
        $privateMessages = $this->getPrivateMessages($request, 'sended');

        return $this->render('FrontendBundle:PrivateMessage:sended.html.twig', [
            'pagination' => $privateMessages
        ]);
    }

    private function getPrivateMessages($request, $type = null)
    {
        $userId = $this->getUser()->getId();

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if ($type == 'sended') {
            $dql = "SELECT p FROM BackendBundle:PrivateMessage p WHERE p.emitter = $userId ORDER BY p.id DESC";
        } else {
            $dql = "SELECT p FROM BackendBundle:PrivateMessage p WHERE p.receiver = $userId ORDER BY p.id DESC";
        }

        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $pagination;
    }
}
