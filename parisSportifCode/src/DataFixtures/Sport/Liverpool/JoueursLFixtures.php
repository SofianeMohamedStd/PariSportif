<?php


namespace App\DataFixtures\Sport\Liverpool;


use App\DataFixtures\Sport\SportFixtures;
use App\Entity\Joueurs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JoueursLFixtures  extends Fixture implements DependentFixtureInterface
{

    public function createJoueur(string $name, string $lastname, string $status): object
    {
        $joueur = new Joueurs();

        $equipe = $this->getReference (EquipeLFixtures::equipe_2);
        $sport = $this->getReference (SportFixtures::sport_1);

        $joueur->setName ($name)
               ->setLastname ($lastname)
               ->setStatus ($status)
               ->setEquipe ($equipe)
               ->setSport ($sport);

        return $joueur;
    }

    /**
     * @inheritDoc
     */
    public function load ( ObjectManager $manager )
    {
       $joueuers = array();
       array_push ($joueuers,$this->createJoueur ('Alisson','Becker','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Robertson','Andrew','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Henderson','Jordan','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Fabinho','Henrique','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('AlexanderArnold','Trent','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Wijnaldum','Georginio','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Alcantara','Thiago','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Shaqiri','Wherdan','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Mane','Roberto','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Firmino','Sadio','Titulaire'));
        array_push ($joueuers,$this->createJoueur ('Salah','Mohammed','Titulaire'));

        foreach ($joueuers as $joueur) {
            $manager->persist ($joueur);
            $manager->flush();
        }




    }

    public function getDependencies () : array
    {
        return [
            SportFixtures::class,
            EquipeLFixtures::class
        ];
    }
}
