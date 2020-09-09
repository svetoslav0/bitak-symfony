<?php


namespace App\Service\Ad;


use App\Entity\Ad;

interface AdServiceInterface
{
    public function save(Ad $ad): bool;
}