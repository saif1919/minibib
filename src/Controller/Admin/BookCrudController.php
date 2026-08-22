<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FileField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Override;


class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    #[Override]
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, '📚 Tous les livres')
            ->setPageTitle(Crud::PAGE_NEW, '➕ Ajouter un livre')
            ->setPageTitle(Crud::PAGE_EDIT, '✏️ Modifier un livre')
            ->setPageTitle(Crud::PAGE_DETAIL, '🔍 Détails du livre');
    }

    #[Override]
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // Add the "Details" action to the index page (not enabled by default)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)

            // "New" button (index page)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter un livre');
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
        $now = new \DateTimeImmutable();
        $year  = $now->format('Y');
        $month = $now->format('m');
        $path = $year . '_' . $month;
        return [
            TextField::new('title')->setLabel('titre')->setRequired(true),
            TextEditorField::new('summary')->setLabel('Résumé')->setRequired(true),
            AssociationField::new('author', 'Auteur')->setRequired(true)->setFormTypeOption('placeholder', 'Choisissez un auteur'),
            AssociationField::new('categories', 'Catégories')->setRequired(true)->setFormTypeOption('attr', ['placeholder' => 'Choisissez une ou plusieurs catégorie(s)']),
            SlugField::new('bookSlug')->setTargetFieldName(['title', 'author']),
            FileField::new('bookfileName', 'Livre')
                ->setUploadDir('public/uploads/books/files/' . $path . '/')
                ->setBasePath('uploads/books/files/' . $path . '/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(true)
                ->maxSize('7M')
                ->mimeTypes('.pdf'),
            ImageField::new('coverImageName', 'Couverture')
                ->setUploadDir('public/uploads/books/image/' . $path . '/')
                ->setBasePath('uploads/books/image/' . $path . '/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(true)
                ->maxSize('2M', 'Le fichier "{{ name }}" dépasse la taille maximale autorisée ({{ limit }} {{ suffix }}).')
                ->mimeTypes('image/jpeg,image/png,image/webp'),
            BooleanField::new('isArchived', 'Archivé')
        ];
    }
}
