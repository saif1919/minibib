<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Override;
use Twig\Markup;

class AuthorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Author::class;
    }


    #[Override]
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, '👤 Tous les auteurs')
            ->setPageTitle(Crud::PAGE_NEW, '➕ Ajouter un auteur')
            ->setPageTitle(Crud::PAGE_EDIT, '✏️ Modifier un auteur')
            ->setPageTitle(Crud::PAGE_DETAIL, '🔍 Détails de l\'auteur');
    }

    #[Override]
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // Add the "Details" action to the index page (not enabled by default)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)

            // "New" button (index page)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter un auteur');
            })

            // "Edit" button (index page)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Éditer');
            })

            // "Delete" button (index page)
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Retirer');
            })

            // Now that it's added, we can customize it
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setLabel('Voir');
            })

            // "Save and return to list" button (form page)
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Créer');
            })

            // "Save and add another" button (form page)
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Créer et ajouter un autre');
            })

            // "Save changes" button (edit page)
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Mettre à jour');
            })

            // "Save and continue editing" button
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action->setLabel('Sauvegarder et continuer');
            })

            // "Index" button (back to list)
            ->update(Crud::PAGE_DETAIL, Action::INDEX, function (Action $action) {
                return $action->setLabel('Retour à la liste');
            })
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstName')->setLabel('Prénom'),
            TextField::new('lastName')->setLabel('Nom')->setRequired(true)->setSortable(true),
            SlugField::new('authorSlug')->setTargetFieldName(['firstName', 'lastName'])->setLabel('Slug'),
            TextEditorField::new('biography')->setLabel('Biographie')->formatValue(fn(string $value) => new Markup($value, 'UTF-8')),
            DateField::new('birthday')->setLabel('Date de naissance')->setFormat('dd-MM-yyyy'),
        ];
    }
}
