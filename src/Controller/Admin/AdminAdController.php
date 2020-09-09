<?php

namespace App\Controller\Admin;

use App\Service\Ad\AdServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     *
     * @return Response
     */
    public function listWaitingAds() {
        $waitingAds = $this->adService->getWaiting();

        return $this->render('admin/ad/showWaiting.html.twig', [
            'ads' => $waitingAds
        ]);
    }

    /**
     * @Route("/admin/ads/{id}", name="show_candidate_ad", methods={"GET"})
     *
     * @param int $id
     * @return Response
     */
    public function viewCandidate(int $id) {
        $ad = $this->adService->getById($id);

        return $this->render('admin/ad/viewCandidate.html.twig', [
            'ad' => $ad
        ]);
    }

    /**
     * @Route("/admin/ads/{id}/approve", name="approve_candidate_ad", methods={"GET"})
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function approveCandidateAd(int $id) {
        $ad = $this->adService->getById($id);

        if (!$ad) {
            return $this->redirectToRoute('list_waiting_ads');
        }

        $this->adService->updateStatusToApproved($ad);
        return $this->redirectToRoute('list_waiting_ads');
    }
}
