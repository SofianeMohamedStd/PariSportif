<?php


namespace App\DataFixtures\Sport\StrasbourgHandball;


use App\DataFixtures\Sport\SportFixtures;
use App\Entity\Joueurs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JoueuersSFixtures extends Fixture implements DependentFixtureInterface
{
    public function createJoueur(string $name, string $lastname, string $status): object
    {
        $joueur = new Joueurs();

        $equipe = $this->getReference (EquipeSFixtures::equipeH_2);
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
        array_push ($players,$this->createJoueur ('Romain','Marhias','Titulaire'));
        array_push ($players,$this->createJoueur ('Maxime','Duchene','Titulaire'));
        array_push ($players,$this->createJoueur ('Jimmy','Portes','Titulaire'));
        array_push ($players,$this->createJoueur ('Yvan','Gerard','Titulaire'));
        array_push ($players,$this->createJoueur ('Lucien','Auffret','Titulaire'));
        array_push ($players,$this->createJoueur ('Lewis','Anzuini','Titulaire'));
        array_push ($players,$this->createJoueur ('Maxime','Mika','Titulaire'));


        foreach ($players as $player) {
            $manager->persist ($player);
            $manager->flush();
        }
    }

    public function getDependencies () : array
    {
        return [
            SportFixtures::class,
            EquipeSFixtures::class
        ];
    }

}