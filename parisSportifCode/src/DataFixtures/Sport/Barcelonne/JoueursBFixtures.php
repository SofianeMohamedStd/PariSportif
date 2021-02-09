<?php


namespace App\DataFixtures\Sport\Barcelonne;


use App\DataFixtures\Sport\SportFixtures;
use App\Entity\Joueurs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JoueursBFixtures extends Fixture implements DependentFixtureInterface
{

    public function createJoueur(string $name, string $lastname, string $status): object
    {
        $joueur = new Joueurs();

        $equipe = $this->getReference (EquipeBFixtures::equipe_1);
        $sport = $this->getReference (SportFixtures::sport_1);

        $joueur->setName ($name)
               ->setLastname ($lastname)
               ->setStatus ($status)
               ->setEquipe ($equipe)
               ->setSport ($sport);

        return $joueur;
    }

    public function load ( ObjectManager $manager )
    {
        $joueuers = array();
        array_push ($joueuers,$this->createJoueur ('Stegen','Marc','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Gerrard','Pique','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Sergino','Dest','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Clement','Lenglet','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Jordi','Alba','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Sergio','Busquets','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Miralem','Pjanic','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Philippe','Coutinho','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Antonie','Griezmann','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Lionel','Messi','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Ansu','Fati','Titulaire'));

        foreach ($joueuers as $joueur) {
            $manager->persist ($joueur);
            $manager->flush();
        }
    }

    public function getDependencies ()
{
    return [
        SportFixtures::class,
        EquipeBFixtures::class
    ];
}

}