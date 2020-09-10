<?php


namespace App\Service\Ad;


use App\Entity\Ad;
use App\Entity\AdStatus;
use App\Repository\AdRepository;
use App\Repository\AdStatusRepository;
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

    public function __construct(
        AdRepository $adRepository,
        AdStatusRepository $adStatusRepository,
        UserRepository $userRepository)
    {
        $this->adRepository = $adRepository;
        $this->adStatusRepository = $adStatusRepository;
        $this->userRepository = $userRepository;
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