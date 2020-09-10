<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\AdStatus;
use App\Form\AdType;
use App\Service\Ad\AdServiceInterface;
use App\Service\User\UserServiceInterface;
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

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * AdController constructor.
     * @param AdServiceInterface $adService
     * @param UserServiceInterface $userService
     */
    public function __construct(
        AdServiceInterface $adService,
        UserServiceInterface $userService
    )
    {
        $this->adService = $adService;
        $this->userService = $userService;
    }

    /**
     * @Route("/ad/create", name="create_ad", methods={"GET"})
     *
     * @return Response
     */
    public function create() {
        $form = $this->createForm(AdType::class);

        return $this->render('ad/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/ad/create", name="create_ad_process", methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function createProcess(Request $request) {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        $this->adService->save($ad, $this->getUser());

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/ad/{id}", name="show_ad")
     *
     * @param int $id
     * @return Response
     */
    public function showAd($id) {
        $ad = $this->adService->getByIdWithStatus(intval($id), AdStatus::STATUS_APPROVED);

        if (!$ad) {
            return $this->redirectToRoute('home');
        }

        return $this->render('ad/showOne.html.twig', [
            'ad' => $ad
        ]);
    }

    /**
     * @Route("/myads", name="show_user_ads")
     */
    public function showUserAds() {
        $ads = $this->adService->getAdsForUser($this->getUser());

        return $this->render('ad/showMyAds.html.twig', [
            'ads' => $ads
        ]);
    }
}
