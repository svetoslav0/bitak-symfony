<?php

namespace App\Controller;

use App\Entity\AdStatus;
use App\Service\Ad\AdServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
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
     * @Route("/", name="home")
     */
    public function home() {
        $ads = $this->adService
            ->getAdsWithStatus(AdStatus::STATUS_APPROVED);

        return $this->render('home/showAds.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * @Route("/admin/home", name="admin_home")
     * @IsGranted("ROLE_ADMIN")
     *
     * WARNING: This method is used for testing purposes!
     */
    public function add() {
        return $this->render('home/add.html.twig');
    }
}
