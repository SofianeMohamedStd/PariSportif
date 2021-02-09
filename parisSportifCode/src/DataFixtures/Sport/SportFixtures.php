<?php


namespace App\DataFixtures\Sport;


use App\Entity\Sport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SportFixtures extends Fixture
{

    public const sport_1 ="sport_1";
    public const sport_2 ="sport_2";

    /**
     * @inheritDoc
     */
    public function load ( ObjectManager $manager )
    {
        $sport = new Sport();
        $sport->setName ('football');
        $sport->setNbTeams (2);
        $sport->setNbPlayers (11);

        $manager->persist ($sport);

        $sport1 = new Sport();
        $sport1->setName ('handball');
        $sport1->setNbTeams (2);
        $sport1->setNbPlayers (7);

        $manager->persist ($sport1);
        $manager->flush ();

        $this->addReference (self::sport_1,$sport);
        $this->addReference (self::sport_2,$sport1);


    }
}