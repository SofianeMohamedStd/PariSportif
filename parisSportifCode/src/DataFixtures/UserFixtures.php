<?php

namespace App\DataFixtures;

use App\Entity\DocumentUser;
use App\Entity\User;
use App\Entity\Wallet;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setWallet(new Wallet());
        $user->setDocument(new DocumentUser());
        $user->setFirstname("namoune");
        $user->setLastname("Sofiane");
        $user->setEmail("sofiane1@gmail.com");
        $user->setBirthDate(DateTime::createFromFormat('Y-m-d', '1994-01-04'));
        $user->setStreet("Rue vauban");
        $user->setStreetNumber("85");
        $user->setCodePostal("68100");
        $user->setCity("Mulhouse");
        $user->setPhone("0797478532");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword('$2y$12$2ccpBT1toKcy/1GWcEcNbeeV2Bp6jjnh.T4ia49tfe6HmyPbpUM0W');
        $manager->persist($user);

        $user2 = new User();
        $user2->setWallet(new Wallet());
        $user2->setDocument(new DocumentUser());
        $user2->setFirstname("bazine");
        $user2->setLastname("mohammmed");
        $user2->setEmail("sofiane2@gmail.com");
        $user2->setBirthDate(DateTime::createFromFormat('Y-m-d', '1994-01-04'));
        $user2->setStreet("XX xx");
        $user2->setStreetNumber("70");
        $user2->setCodePostal("75000");
        $user2->setCity("paris");
        $user2->setPhone("0697478532");
        $user2->setRoles(["ROLE_USER"]);
        $user2->setPassword('$2y$12$2ccpBT1toKcy/1GWcEcNbeeV2Bp6jjnh.T4ia49tfe6HmyPbpUM0W');
        $manager->persist($user2);

        $user3 = new User();
        $user3->setWallet(new Wallet());
        $user3->setDocument(new DocumentUser());
        $user3->setFirstname("Tintin");
        $user3->setLastname("Dupont");
        $user3->setEmail("tintin.dupont@mail.com");
        $user3->setBirthDate(DateTime::createFromFormat('Y-m-d', '1994-02-21'));
        $user3->setStreet("Rue de la bichette");
        $user3->setStreetNumber("3");
        $user3->setCodePostal("67640");
        $user3->setCity("Lipsheim");
        $user3->setPhone("0612345678");
        $user3->setRoles(["ROLE_ADMIN"]);
        $user3->setPassword($this->passwordEncoder->encodePassword($user, '@Test123'));
        $manager->persist($user3);

        $manager->flush();
    }
}
