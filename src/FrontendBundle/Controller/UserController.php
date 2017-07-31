<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use FrontendBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    /** @var Session $session */
    private $session;

    public function loginAction()
    {
        if (is_object($this->getUser())) {
            return $this->redirect('home');
        }

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUserName = $authenticationUtils->getLastUsername();

        return $this->render('FrontendBundle:User:login.html.twig', [
            'last_username' => $lastUserName,
            'error' => $error
        ]);
    }

    public function __construct()
    {
        $this->session = new Session();
    }

    public function registerAction(Request $request) {
        if (is_object($this->getUser())) {
            return $this->redirect('home');
        }

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                list($em, $user_isset) = $this->checkIfUserIsAlreadyRegistered($form);

                if (count($user_isset) == 0) {
                    $flush = $this->registerNewUser($user, $form, $em);

                    if ($flush === null) {
                        $status = 'Te has registrado correctamente!';

                        $this->session->getFlashBag()->add("status", $status);

                        return $this->redirect('login');
                    } else {
                        $status = 'No te has registrado correctamente :(';
                    }

                } else {
                    $status = 'Este usuario ya existe';
                }

            } else {
                $status = "No te has registrado correctamente :(";
            }
            $this->session->getFlashBag()->add("status", $status);
        }

        return $this->render('FrontendBundle:User:register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function nickTestAction(Request $request) {
        $nick = $request->get("nick");
        $em = $this->getDoctrine()->getManager();
        $user_repo = $em->getRepository('BackendBundle:User');
        $user_isset = $user_repo->findOneBy(["nick" => $nick]);

        if (count($user_isset) >= 1 && is_object($user_isset)) {
            $result = 'used';
        } else {
            $result = 'unused';
        }

        return new Response($result);
    }

    public function editUserAction(Request $request) {


        return $this->render('FrontendBundle:User:edit_user.html.twig');
    }

    /**
     * @param $form
     * @return array
     */
    protected function checkIfUserIsAlreadyRegistered($form): array
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $query = $em
            ->createQuery('SELECT u FROM BackendBundle:User u WHERE u.email = :email OR u.nick = :nick')
            ->setParameter('email', $form->get('email')->getData())
            ->setParameter('nick', $form->get('nick')->getData());

        $user_isset = $query->getResult();
        return array($em, $user_isset);
    }

    /**
     * @param $user
     * @param $form
     * @param $em
     * @return mixed
     */
    protected function registerNewUser($user, $form, $em)
    {
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        $password = $encoder->encodePassword($form->get('password')->getData(), $user->getSalt());

        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setImage(null);

        $em->persist($user);
        $flush = $em->flush();
        return $flush;
    }
}
