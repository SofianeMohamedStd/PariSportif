<?php


namespace App\DataFixtures\Sport\NiceHandball;


use App\DataFixtures\Sport\SportFixtures;
use App\Entity\Joueurs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JoueursNFixtures extends Fixture implements DependentFixtureInterface
{
    public function createJoueur(string $name, string $lastname, string $status): object
    {
        $joueur = new Joueurs();

        $equipe = $this->getReference (EquipeNFixtures::equipeH_1);
        $sport = $this->getReference (SportFixtures::sport_2);

        $joueur->setName ($name)
            ->setLastname ($lastname)
            ->setStatus ($status)
            ->setEquipe ($equipe)
            ->setSport ($sport);

        return $joueur;
    }

    public function load ( ObjectManager $manager )
    {
        $players = array();
        array_push ($players,$this->createJoueur ('Marija','Colic','Titulaire'));
        array_push ($players,$this->createJoueur ('Kimberley','Boucharb','Titulaire'));
        array_push ($players,$this->createJoueur ('Marie','Prouvensier','Titulaire'));
        array_push ($players,$this->createJoueur ('Marija','Janjic','Titulaire'));
        array_push ($players,$this->createJoueur ('Martina','Skolkova','Titulaire'));
        array_push ($players,$this->createJoueur ('Melissa','Agathe','Titulaire'));
        array_push ($players,$this->createJoueur ('Ehsan','Abdelmalek','Titulaire'));


        foreach ($players as $player) {
            $manager->persist ($player);
            $manager->flush();
        }
    }

    public function getDependencies () : array
    {
        return [
            SportFixtures::class,
            EquipeNFixtures::class
        ];
    }

}