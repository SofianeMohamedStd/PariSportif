<?php


namespace App\DataFixtures;


use App\Entity\Bet;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BetFixtures extends Fixture implements DependentFixtureInterface
{

    public function load ( ObjectManager $manager )
    {
        $evenement = $this->getReference (EvenementFixtures::evenement_1);
        $evenement2 = $this->getReference(EvenementFixtures::evenement_2);
        $bet = new Bet();
        $bet->setNameBet ('victoire Barcelone');
        $bet->setCote (1.20);
        $bet->setDateBetLimit((new DateTime())->add(new DateInterval('P2D')));
        $bet->setEvenement ($evenement);
        $manager->persist ($bet);

        $bet1 = new Bet();
        $bet1->setNameBet ('victoire Liverpool');
        $bet1->setCote (2.20);
        $bet1->setDateBetLimit((new DateTime())->add(new DateInterval('P2D')));
        $bet1->setEvenement ($evenement);
        $manager->persist ($bet1);

        $bet2 = new Bet();
        $bet2->setNameBet ('match null');
        $bet2->setCote (3);
        $bet2->setDateBetLimit((new DateTime())->add(new DateInterval('P2D')));
        $bet2->setEvenement ($evenement);
        $manager->persist ($bet2);

        $bet3 = new Bet();
        $bet3->setNameBet ('victoire nice');
        $bet3->setCote (2.2);
        $bet3->setDateBetLimit((new DateTime())->add(new DateInterval('P2D')));
        $bet3->setEvenement ($evenement2);
        $manager->persist ($bet3);

        $bet4 = new Bet();
        $bet4->setNameBet ('victoire Strasbourg');
        $bet4->setCote (1.2);
        $bet4->setDateBetLimit((new DateTime())->add(new DateInterval('P2D')));
        $bet4->setEvenement ($evenement2);
        $manager->persist ($bet4);

        $bet5 = new Bet();
        $bet5->setNameBet ('match null');
        $bet5->setCote (5);
        $bet5->setDateBetLimit((new DateTime())->add(new DateInterval('P2D')));
        $bet5->setEvenement ($evenement2);
        $manager->persist ($bet5);

        $manager->flush ();

    }

    public function getDependencies (): array
    {
        return [
            EvenementFixtures::class
        ];
    }
}