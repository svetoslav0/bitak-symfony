<?php

namespace App\Controller;

use App\Entity\AdStatus;
use App\Service\Ad\AdServiceInterface;
use App\Service\Category\CategoriesServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var AdServiceInterface
     */
    private $adService;

    /**
     * @var CategoriesServiceInterface
     */
    private $categoryService;

    public function __construct(
        AdServiceInterface $adService,
        CategoriesServiceInterface $categoriesService
    )
    {
        $this->adService = $adService;
        $this->categoryService = $categoriesService;
    }

    /**
     * @Route("/", name="home")
     */
    public function home() {
        $ads = $this->adService
            ->getAdsWithStatus(AdStatus::STATUS_APPROVED);
        $categories = $this->categoryService->getAll();

        return $this->render('home/showAds.html.twig', [
            'ads' => $ads,
            'categories' => $categories
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
