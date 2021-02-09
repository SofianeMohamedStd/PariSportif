<?php


namespace App\DataFixtures\Sport\Barcelonne;


use App\DataFixtures\Sport\SportFixtures;
use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EquipeBFixtures extends Fixture implements DependentFixtureInterface
{
    public const equipe_1 ="equipe_1";



    public function load ( ObjectManager $manager )
    {
        $sport = $this->getReference (SportFixtures::sport_1);
        $equipe = new Equipe();

        $equipe->setName ('barcelonne')
                ->setContry('Espagne')
                ->setSport ($sport);

        $manager->persist ($equipe);
        $manager->flush ();

        $this->addReference (self::equipe_1,$equipe);
    }

    public function getDependencies ()
{
    return [
        SportFixtures::class
    ];
}
}