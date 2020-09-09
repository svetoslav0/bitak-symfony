<?php


namespace App\Service\User;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Encryption\EncryptionServiceInterface;

class UserService implements UserServiceInterface
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EncryptionServiceInterface
     */
    private $encryptionService;

    public function __construct(
        UserRepository $userRepository,
        EncryptionServiceInterface $encryptionService)
    {
        $this->userRepository = $userRepository;
        $this->encryptionService = $encryptionService;
    }

    public function save(User $user): bool
    {
        return $this->userRepository->insert(
            $this->initUser($user)
        );
    }

    private function initUser(User $user): User {
        $passwordHash = $this->encryptionService->encrypt($user->getPassword());
        $user->setPassword($passwordHash);

        return $user;
    }
}