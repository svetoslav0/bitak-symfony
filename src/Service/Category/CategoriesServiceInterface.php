<?php


namespace App\Service\Category;


use App\Entity\Category;

interface CategoriesServiceInterface
{
    /**
     * @return Category[]
     */
    public function getAll(): array;
}