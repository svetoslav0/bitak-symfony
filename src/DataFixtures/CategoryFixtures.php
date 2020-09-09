<?php


namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    const DEFAULT_CATEGORIES = [
        'Cars and Boats',
        'Fashion',
        'Services',
        'Electronics'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::DEFAULT_CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
            $manager->flush();
        }
    }
}