<?php


namespace App\DataFixtures\Sport\StrasbourgHandball;


use App\DataFixtures\Sport\SportFixtures;
use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EquipeSFixtures extends Fixture implements DependentFixtureInterface
{
    public const equipeH_2 ="equipeH_2";

    public function load ( ObjectManager $manager )
    {
        $sport = $this->getReference (SportFixtures::sport_2);
        $equipe1 = new Equipe();

        $equipe1->setName ('Strasbourg')
            ->setContry('France')
            ->setSport ($sport);

        $manager->persist ($equipe1);
        $manager->flush ();

        $this->addReference (self::equipeH_2,$equipe1);
    }

    public function getDependencies(): array
    {
        return [
            SportFixtures::class
        ];
    }

}