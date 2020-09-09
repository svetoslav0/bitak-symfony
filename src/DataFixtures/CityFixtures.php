<?php


namespace App\DataFixtures;


use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{

    const CITIES = [
        'Sofia',
        'Varna',
        'Plovdiv',
        'Burgas',
        'Pleven',
        'Ruse',
        'Blagoevgrad',
        'Vidin',
        'Vratsa',
        'Dobrich',
        'Montana'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CITIES as $cityName) {
            $city = new City();
            $city->setName($cityName);

            $manager->persist($city);
            $manager->flush();
        }
    }
}