<?php


namespace App\Service\Category;


use App\Entity\Category;

interface CategoriesServiceInterface
{
    /**
     * @return Category[]
     */
    public function getAll(): array;

    /**
     * @param int $id
     * @return Category
     */
    public function getById($id): ?Category;
}