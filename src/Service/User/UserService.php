<?php


namespace App\Service\User;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Encryption\EncryptionServiceInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param EncryptionServiceInterface $encryptionService
     */
    public function __construct(
        UserRepository $userRepository,
        EncryptionServiceInterface $encryptionService)
    {
        $this->userRepository = $userRepository;
        $this->encryptionService = $encryptionService;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool
    {
        return $this->userRepository->insert(
            $this->initUser($user)
        );
    }

    /**
     * @param User $user
     * @return User
     */
    private function initUser(User $user): User {
        $passwordHash = $this->encryptionService->encrypt($user->getPassword());
        $user->setPassword($passwordHash);

        return $user;
    }
}