<?php

namespace App\Controller\Admin;

use App\Entity\Bet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;



class BetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bet::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            AssociationField::new('evenement'),
            TextareaField::new('name_bet'),
            DateTimeField::new('date_bet_limit'),
            NumberField::new('cote'),
            BooleanField::new('result_bet')
        ];
    }

}
