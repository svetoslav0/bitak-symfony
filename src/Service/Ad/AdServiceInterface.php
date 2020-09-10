<?php


namespace App\Service\Ad;


use App\Entity\Ad;
use App\Entity\AdStatus;
use Symfony\Component\Security\Core\User\UserInterface;

interface AdServiceInterface
{
    /**
     * @param Ad $ad
     * @param UserInterface $user
     * @return bool
     */
    public function save(Ad $ad, UserInterface $user): bool;

    /**
     * @return Ad[]
     */
    public function getWaiting(): array;

    /**
     * @param int $id
     * @return Ad
     */
    public function getById(int $id): Ad;

    /**
     * @param int $adId
     * @param string $status
     * @return bool
     */
    public function updateAdStatus(int $adId, string $status): bool;
}