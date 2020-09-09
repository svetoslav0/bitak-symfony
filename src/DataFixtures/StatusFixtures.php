<?php


namespace App\DataFixtures;


use App\Entity\AdStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    const STATUSES = [
        AdStatus::STATUS_WAITING,
        AdStatus::STATUS_APPROVED,
        AdStatus::STATUS_REJECTED,
        AdStatus::STATUS_ARCHIVED
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUSES as $statusName) {
            $status = new AdStatus();
            $status->setName($statusName);

            $manager->persist($status);
            $manager->flush();
        }
    }
}