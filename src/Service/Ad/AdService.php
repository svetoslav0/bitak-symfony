<?php


namespace App\Service\Ad;


use App\Entity\Ad;
use App\Entity\AdStatus;
use App\Repository\AdRepository;
use App\Repository\AdStatusRepository;

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

    public function __construct(
        AdRepository $adRepository,
        AdStatusRepository $adStatusRepository)
    {
        $this->adRepository = $adRepository;
        $this->adStatusRepository = $adStatusRepository;
    }

    /**
     * @param Ad $ad
     * @return bool
     */
    public function save(Ad $ad): bool
    {
        $statusWaiting = $this->adStatusRepository
            ->findOneBy(['name' => AdStatus::STATUS_WAITING]);

        $ad->setStatus($statusWaiting);
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