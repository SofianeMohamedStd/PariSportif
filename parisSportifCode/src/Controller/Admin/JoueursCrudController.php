<?php

namespace App\Controller\Admin;

use App\Entity\Joueurs;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JoueursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Joueurs::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('lastname'),
            TextField::new('status'),
            AssociationField::new('equipe'),
            AssociationField::new('sport'),
        ];
    }

}
