<?php


namespace App\Service\Category;


use App\Entity\Category;
use App\Repository\CategoryRepository;

class CategoryService implements CategoriesServiceInterface
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return Category[]
     */
    public function getAll(): array
    {
        return $this->categoryRepository->findAll();
    }

    /**
     * @param int $id
     * @return Category
     */
    public function getById($id): ?Category
    {
        return $this->categoryRepository->find($id);
    }
}