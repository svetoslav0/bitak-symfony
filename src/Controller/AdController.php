<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Service\Ad\AdServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * @var AdServiceInterface
     */
    private $adService;

    public function __construct(AdServiceInterface $adService)
    {
        $this->adService = $adService;
    }

    /**
     * @Route("/ad/create", name="create_ad", methods={"GET"})
     *
     * @return Response
     */
    public function create() {
        $form = $this->createForm(AdType::class);

        return $this->render('ad/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ad/create", name="create_ad_process", methods={"POST"})
     *
     * @param Request $request
     */
    public function createProcess(Request $request) {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        $this->adService->save($ad);

        return $this->redirectToRoute('home');
    }
}
