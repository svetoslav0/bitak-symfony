<?php

namespace App\Controller\Admin;

use App\Entity\AdStatus;
use App\Service\Ad\AdServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $waitingAds = $this->adService->getAdsWithStatus(AdStatus::STATUS_WAITING);

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
        return $this->updateAdStatus(
            $id,
            AdStatus::STATUS_APPROVED,
            'list_waiting_ads'
        );
    }

    /**
     * @Route("/admin/ads/{id}/reject", name="reject_candidate_ad", methods={"GET"})
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function rejectCandidateAd(int $id) {
        return $this->updateAdStatus(
            $id,
            AdStatus::STATUS_REJECTED,
            'list_waiting_ads'
        );
    }

    /**
     * @param int $id
     * @param string $status
     * @param string $routeToRedirect
     * @return RedirectResponse
     */
    private function updateAdStatus(int $id, string $status, string $routeToRedirect) {
        $ad = $this->adService->getById($id);

        if ($ad) {
            $this->adService->updateAdStatus($id, $status);
        }

        return $this->redirectToRoute($routeToRedirect);
    }
}
