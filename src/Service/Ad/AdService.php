<?php


namespace App\Service\Ad;


use App\Entity\Ad;
use App\Entity\AdStatus;
use App\Repository\AdRepository;
use App\Repository\AdStatusRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class AdService implements AdServiceInterface
{
    /**
     * @var AdRepository
     */
    private $adRepository;

    /**
     * @var AdStatusRepository
     */
    private $adStatusRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(
        AdRepository $adRepository,
        AdStatusRepository $adStatusRepository,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository)
    {
        $this->adRepository = $adRepository;
        $this->adStatusRepository = $adStatusRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Ad $ad
     * @param UserInterface $user
     * @return bool
     */
    public function save(Ad $ad, UserInterface $user): bool
    {
        $statusWaiting = $this->adStatusRepository
            ->findOneBy(['name' => AdStatus::STATUS_WAITING]);
        $userEntity = $this->userRepository
            ->findOneBy(['email' => $user->getUsername()]);

        $ad->setStatus($statusWaiting);
        $ad->setUser($userEntity);

        return $this->adRepository->insertOrUpdate($ad);
    }

    /**
     * @param int $id
     * @return Ad
     */
    public function getById(int $id): Ad
    {
        return $this->adRepository->find($id);
    }

    public function getByIdWithStatus(int $id, string $status): ?Ad
    {
        $status = $this->adStatusRepository->findOneBy(['name' => $status]);

        return $this->adRepository->findOneBy([
            'id' => $id,
            'status' => $status
        ]);
    }

    /**
     * @param int $adId
     * @param string $status
     * @return bool
     */
    public function updateAdStatus(int $adId, string $status): bool
    {
        $ad = $this->adRepository->find($adId);
        $status = $this->adStatusRepository->findOneBy(['name' => $status]);

        $ad->setStatus($status);
        return $this->adRepository->insertOrUpdate($ad);
    }

    /**
     * @param string $status
     * @return Ad[]
     */
    public function getAdsWithStatus(string $status): array
    {
        $adStatus = $this->adStatusRepository
            ->findOneBy(['name' => $status]);

        $ads = $this->adRepository->findBy(['status' => $adStatus]);
        return $this->buildAdsWithShortDescription($ads);
    }

    /**
     * @param UserInterface $user
     * @return Ad[]
     */
    public function getAdsForUser(UserInterface $user): array
    {
        $userEntity = $this->userRepository
            ->findOneBy(['email' => $user->getUsername()]);

        $ads = $this->adRepository->findBy(['user' => $userEntity]);
        return $this->buildAdsWithShortDescription($ads);
    }

    /**
     * @param $categoryId
     * @param string $status
     * @return Ad[]
     */
    public function getAllForCategoryWithStatus($categoryId, string $status): array
    {
        $category = $this->categoryRepository->find($categoryId);
        $status = $this->adStatusRepository->findBy(['name' => $status]);

        $ads = $this->adRepository->findBy([
            'category' => $category,
            'status' => $status
        ]);

        return $this->buildAdsWithShortDescription($ads);
    }

    /**
     * @param Ad[] $ads
     * @return Ad[]
     */
    private function buildAdsWithShortDescription($ads) {
        foreach ($ads as $ad) {
            if (strlen($ad->getDescription()) >= Ad::MAX_SHORT_DESCRIPTION_LENGTH) {
                $shortDescription = substr(
                        $ad->getDescription(),
                        0,
                        Ad::MAX_SHORT_DESCRIPTION_LENGTH) . ' . . .';

                $ad->setShortDescription($shortDescription);
                continue;
            }

            $ad->setShortDescription($ad->getDescription());
        }

        return $ads;
    }
}