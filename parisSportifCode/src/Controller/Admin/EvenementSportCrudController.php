<?php

namespace App\Controller\Admin;

use App\Entity\EvenementSport;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EvenementSportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EvenementSport::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('name'),
            DateTimeField::new('begin_date'),
            AssociationField::new('sport'),
            AssociationField::new('competionn'),
            TextField::new('event_place')
        ];
    }

}
