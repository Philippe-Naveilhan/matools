<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin@monsite.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->EncodePassword($user, 'Admin'));
        $manager->persist($user);

        $user = new User();
        $user->setUsername('travail@naveilhan.com');
        $user->setRoles(['ROLE_MEMBER']);
        $user->setPassword($this->passwordEncoder->EncodePassword($user, 'Ad&ju1976'));
        $manager->persist($user);

        $manager->flush();
    }
}
