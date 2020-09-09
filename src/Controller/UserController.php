<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/register",
     *     name="user_register",
     *     methods={"GET"})
     *
     * @return Response
     */
    public function register() {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(UserType::class);

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/register",
     *     name="user_register_process",
     *     methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function registerProcess(Request $request) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $this->userService->save($user);

        return $this->redirectToRoute('app_login');
    }
}
