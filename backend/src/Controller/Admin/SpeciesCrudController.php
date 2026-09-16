<?php

namespace App\Controller\Admin;

use App\Entity\Species;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SpeciesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Species::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name','Nom'),
            //CollectionField::new('races','Races associées'),
            CollectionField::new('races', 'Races')
            ->onlyOnIndex()
            ->formatValue(function ($value, $entity) {
                // $value est une Collection Doctrine d'objets Race
                if ($value->isEmpty()) {
                    return '<em>Aucune race</em>';
                }

                $html = '<ul class="mb-0 ps-3">';
                foreach ($value as $race) {
                    $html .= sprintf('<li>%s</li>', htmlspecialchars($race->getName()));
                }
                $html .= '</ul>';

                return $html;
            }),
        ];
    }
    
}
