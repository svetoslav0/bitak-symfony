<?php

namespace App\Controller\Admin;

use App\Service\Ad\AdServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdController extends AbstractController
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
     * @Route("/admin/ads/waiting", name="list_waiting_ads")
     */
    public function listWaitingAds() {
        $waitingAds = $this->adService->getWaiting();

        return $this->render('admin/ad/showWaiting.html.twig', [
            'ads' => $waitingAds
        ]);
    }
}
