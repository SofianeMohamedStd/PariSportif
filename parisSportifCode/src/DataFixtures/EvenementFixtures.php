<?php


namespace App\DataFixtures;


use App\DataFixtures\Sport\Barcelonne\EquipeBFixtures;
use App\DataFixtures\Sport\Liverpool\EquipeLFixtures;
use App\DataFixtures\Sport\NiceHandball\EquipeNFixtures;
use App\DataFixtures\Sport\SportFixtures;
use App\DataFixtures\Sport\StrasbourgHandball\EquipeSFixtures;
use App\Entity\EvenementSport;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EvenementFixtures extends Fixture implements DependentFixtureInterface
{

    public const evenement_1 ="evenement_1";
    public const evenement_2 ="evenement_2";

    /**
     * @inheritDoc
     */
    public function load ( ObjectManager $manager )
    {
        $evenement1 = new EvenementSport();
        $evenement2 = new EvenementSport();
        $sport = $this->getReference (SportFixtures::sport_1);
        $sport2 = $this->getReference(SportFixtures::sport_2);
        $equipe1 = $this->getReference (EquipeBFixtures::equipe_1);
        $equipe2 = $this->getReference (EquipeLFixtures::equipe_2);
        $equipeH1 = $this->getReference(EquipeNFixtures::equipeH_1);
        $equipeH2 = $this->getReference(EquipeSFixtures::equipeH_2);
        $competition = $this->getReference (CompetitionFixtures::competition_1);
        $competition2 = $this->getReference(CompetitionFixtures::competition_2);

        $evenement1->setName ('Face des groupes - journée 2')
            ->setBeginDate (DateTime::createFromFormat ('Y-m-d H:i:s','2021-01-29 19:00:00'))
            ->setEventPlace ('Espagne')
            ->setSport ($sport)
            ->addEquipe ($equipe1)
            ->addEquipe ($equipe2)
            ->setCompetionn ($competition);
        $manager->persist ($evenement1);

        $evenement2->setName ('premier tour - journée 1')
            ->setBeginDate (DateTime::createFromFormat ('Y-m-d H:i:s','2021-01-29 19:00:00'))
            ->setEventPlace ('France')
            ->setSport ($sport2)
            ->addEquipe ($equipeH1)
            ->addEquipe ($equipeH2)
            ->setCompetionn ($competition2);
        $manager->persist ($evenement2);

        $this->addReference (self::evenement_1,$evenement1);
        $this->addReference (self::evenement_2,$evenement2);
        $manager->flush ();


    }

    public function getDependencies (): array
    {
        return [
            CompetitionFixtures::class,
            SportFixtures::class,
            EquipeLFixtures::class,
            EquipeBFixtures::class,
            EquipeNFixtures::class,
            EquipeSFixtures::class
        ];
    }
}