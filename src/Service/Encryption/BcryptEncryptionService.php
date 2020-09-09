<?php


namespace App\Service\Encryption;


class BcryptEncryptionService implements EncryptionServiceInterface
{

    const ENCRYPTION_ALGORITHM = PASSWORD_BCRYPT;

    public function encrypt($password): string
    {
        return password_hash($password, self::ENCRYPTION_ALGORITHM);
    }
}