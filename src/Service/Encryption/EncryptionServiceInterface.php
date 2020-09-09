<?php


namespace App\Service\Encryption;


interface EncryptionServiceInterface
{
    public function encrypt($password): string;
}