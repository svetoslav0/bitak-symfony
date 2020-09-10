<?php


namespace App\Service\User;


use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserServiceInterface
{
    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool;
}