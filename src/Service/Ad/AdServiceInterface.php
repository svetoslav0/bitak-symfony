<?php


namespace App\Service\Ad;


use App\Entity\Ad;

interface AdServiceInterface
{
    /**
     * @param Ad $ad
     * @return bool
     */
    public function save(Ad $ad): bool;

    /**
     * @return Ad[]
     */
    public function getWaiting(): array;
}