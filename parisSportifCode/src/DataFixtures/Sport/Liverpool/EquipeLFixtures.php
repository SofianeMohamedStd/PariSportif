<?php


namespace App\DataFixtures\Sport\Liverpool;


use App\DataFixtures\Sport\SportFixtures;
use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EquipeLFixtures extends Fixture implements DependentFixtureInterface
{


    public const equipe_2 ="equipe_2";

    /**
     * @inheritDoc
     */
    public function load ( ObjectManager $manager )
    {
        $sport = $this->getReference (SportFixtures::sport_1);
        $equipe1 = new Equipe();

        $equipe1->setName ('Liverpool')
                ->setContry('Anglettere')
                ->setSport ($sport);

        $manager->persist ($equipe1);
        $manager->flush ();

        $this->addReference (self::equipe_2,$equipe1);
    }

    public function getDependencies(): array
    {
        return [
            SportFixtures::class
        ];
    }
}
