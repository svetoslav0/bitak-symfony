<?php

namespace App\Controller;

use App\Entity\AdStatus;
use App\Service\Ad\AdServiceInterface;
use App\Service\Category\CategoriesServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @var AdServiceInterface
     */
    private $adService;

    /**
     * @var CategoriesServiceInterface
     */
    private $categoryService;

    /**
     * CategoryController constructor.
     * @param AdServiceInterface $adService
     * @param CategoriesServiceInterface $categoriesService
     */
    public function __construct(
        AdServiceInterface $adService,
        CategoriesServiceInterface $categoriesService
    )
    {
        $this->adService = $adService;
        $this->categoryService = $categoriesService;
    }

    /**
     * @Route("/category/{id}", name="ads_in_category")
     * @param int $id
     * @return Response
     */
    public function showAdsForCategory($id) {
        $ads = $this->adService->getAllForCategoryWithStatus($id, AdStatus::STATUS_APPROVED);
        $category = $this->categoryService->getById($id);

        if (!$category) {
            return $this->redirectToRoute('home');
        }

        return $this->render('ad/showMultiple.html.twig', [
            'ads' => $ads,
            'category' => $category
        ]);
    }
}
