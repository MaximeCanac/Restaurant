<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;


class AppFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User;
                $user->setUsername("admin");
                $user->setPassword($this->passwordHasher->hashPassword($user,'rascol'));
        $roles[] = 'ROLE_ADMIN';
        $user->setRoles($roles);
        $manager->persist($user);
        $manager->flush();
    }
}
