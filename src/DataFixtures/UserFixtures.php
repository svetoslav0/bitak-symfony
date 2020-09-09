<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const DEFAULT_USER = 'admin@dir.bg';
    const DEFAULT_PASSWORD = 'admin';

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail(self::DEFAULT_USER);
        $user->setPassword($this->encoder->encodePassword($user, self::DEFAULT_PASSWORD));
        $manager->persist($user);

        $manager->flush();
    }
}