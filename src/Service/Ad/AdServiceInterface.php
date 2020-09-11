<?php


namespace App\Service\Ad;


use App\Entity\Ad;
use Symfony\Component\Form\FormInterface;
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
     * @param Ad $ad
     * @return bool
     */
    public function update(Ad $ad): bool;

    /**
     * @param int $id
     * @return Ad
     */
    public function getById(int $id): ?Ad;

    /**
     * @param int $id
     * @param string $status
     * @return Ad
     */
    public function getByIdWithStatus(int $id, string $status): ?Ad;

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

    /**
     * @param UserInterface $user
     * @return Ad[]
     */
    public function getAdsForUser(UserInterface $user): array;

    /**
     * @param $categoryId
     * @param string $status
     * @return Ad[]
     */
    public function getAllForCategoryWithStatus($categoryId, string $status): array;

    /**
     * @param $adId
     * @param UserInterface|null $user
     * @return bool
     */
    public function isUserOwner($adId, ?UserInterface $user): bool;

    /**
     * @param Ad $ad
     * @param FormInterface $form
     * @return FormInterface
     */
    public function getEditFormWithData(Ad $ad, FormInterface $form): FormInterface;
}