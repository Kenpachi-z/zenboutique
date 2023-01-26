<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;


class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
           ImageField::new('illustration')
            ->setBasePath('img')
            ->setUploadDir('public/img')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            
            TextField::new('subtitle'),
            TextareaField::new('description'),
            BooleanField::new('active'),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('category'),
            
      
            
        ];
    }
    
}
