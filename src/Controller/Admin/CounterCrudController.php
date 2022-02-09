<?php

namespace App\Controller\Admin;

use App\Entity\Counter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class CounterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Counter::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('counter_of_sites')->setLabel('Nombre de site'),
            IntegerField::new('counter_of_years_work')->setLabel('Nombre d\'année taff'),
            IntegerField::new('counter_of_clients')->setLabel('Nombre de client'),
            IntegerField::new('counter_of_win')->setLabel('Projet en cours'),
            IntegerField::new('counter_of_years')->setLabel('Année du copyright'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Compteur d\'information');
    }

}
