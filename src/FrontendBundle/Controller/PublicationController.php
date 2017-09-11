<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FrontendBundle\Form\PublicationType;

class PublicationController extends Controller
{
    public function indexAction(Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);

        return $this->render('FrontendBundle:Publication:home.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
