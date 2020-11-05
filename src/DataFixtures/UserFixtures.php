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
        $user->setUsername('Admin');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->EncodePassword($user, 'Admin'));

        $manager->persist($user);

        for($i=0; $i<10; $i++){
            $user = new User();
            $user->setUsername('Prof'.$i);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordEncoder->EncodePassword($user, 'Prof'.$i));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
