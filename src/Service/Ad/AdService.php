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

        return $this->adRepository->insert($ad);
    }

    /**
     * @return Ad[]
     */
    public function getWaiting(): array
    {
        $statusWaiting = $this->adStatusRepository
            ->findOneBy(['name' => AdStatus::STATUS_WAITING]);

        return $this->adRepository->findBy(['status' => $statusWaiting]);
    }
}