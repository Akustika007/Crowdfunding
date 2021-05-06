<?php

namespace App\Controller\Admin;

use App\Entity\Crowdfunding;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CrowdfundingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Crowdfunding::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('user')->hideOnForm(),
        ];
    }

}
