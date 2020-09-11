<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\AdStatus;
use App\Entity\User;
use App\Form\AdType;
use App\Service\Ad\AdServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    const SUCCESS_FLASH_TYPE = 'success';
    const WARNING_FLASH_TYPE = 'warning';

    const SUCCESSFULLY_DELETE_AD_MESSAGE = 'Ad was successfully deleted!';
    const NO_EDIT_ACCESS_FLASH_MESSAGE = 'You have no access to edit this ad!';

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
     *
     * @return Response
     */
    public function showUserAds() {
        $ads = $this->adService->getAdsForUser($this->getUser());

        return $this->render('ad/showMyAds.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * @Route("/ad/{id}/edit", name="edit_ad", methods={"GET"})
     *
     * @param int $id
     * @return Response
     */
    public function editAd($id) {
        if (!$this->hasAccess($id)) {
            $this->addFlash(self::WARNING_FLASH_TYPE, self::NO_EDIT_ACCESS_FLASH_MESSAGE);
            return $this->redirectToRoute('home');
        }

        return $this->render('ad/edit.html.twig');
    }

    /**
     * @Route("/ad/{id}/delete", name="delete_ad")
     *
     * @param int $id
     * @return Response
     */
    public function deleteAd($id) {
        if ($this->hasAccess($id)) {
            $this->addFlash(self::SUCCESS_FLASH_TYPE, self::SUCCESSFULLY_DELETE_AD_MESSAGE);
            $this->adService->updateAdStatus($id, AdStatus::STATUS_ARCHIVED);
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @param int $adId
     * @return bool
     */
    private function hasAccess($adId) {
        return $this->adService->isUserOwner($adId, $this->getUser()) ||
            in_array(User::ROLE_ADMIN, $this->getUser()->getRoles());
    }
}
