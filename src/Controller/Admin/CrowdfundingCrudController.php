<?php

namespace App\Controller\Admin;

use App\Entity\Crowdfunding;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CrowdfundingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Crowdfunding::class;
    }


//    public function configureFields(string $pageName): iterable
//    {
//        return [
//            TextField::new('autor'),
//            TextEditorField::new('text'),
//            TextField::new('email'),
//        ];
//    }

}
