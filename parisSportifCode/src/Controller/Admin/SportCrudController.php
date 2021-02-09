<?php

namespace App\Controller\Admin;

use App\Entity\Sport;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sport::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('name'),
            NumberField::new('nb_teams'),
            NumberField::new('nb_players')
        ];
    }

}
