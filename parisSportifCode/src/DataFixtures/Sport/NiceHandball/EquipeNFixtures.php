<?php


namespace App\DataFixtures\Sport\NiceHandball;


use App\DataFixtures\Sport\SportFixtures;
use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EquipeNFixtures extends Fixture implements DependentFixtureInterface
{
    public const equipeH_1 ="equipeH_1";

    public function load ( ObjectManager $manager )
    {
        $sport = $this->getReference (SportFixtures::sport_2);
        $equipe1 = new Equipe();

        $equipe1->setName ('Nice')
            ->setContry('France')
            ->setSport ($sport);

        $manager->persist ($equipe1);
        $manager->flush ();

        $this->addReference (self::equipeH_1,$equipe1);
    }

    public function getDependencies(): array
    {
        return [
            SportFixtures::class
        ];
    }

}