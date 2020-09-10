<?php


namespace App\Service\Ad;


use App\Entity\Ad;
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

    /**
     * @param string $status
     * @return Ad[]
     */
    public function getAdsWithStatus(string $status): array;
}