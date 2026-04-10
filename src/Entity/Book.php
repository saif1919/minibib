<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $summary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bookSlug = null;

    #[ORM\Column]
    private ?bool $isArchived = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bookFileName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bookFilePath = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coverImageName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coverImagePath = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Author $author = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'books')]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getBookSlug(): ?string
    {
        return $this->bookSlug;
    }

    public function setBookSlug(?string $bookSlug): static
    {
        $this->bookSlug = $bookSlug;

        return $this;
    }

    public function isArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $isArchived): static
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getBookFileName(): ?string
    {
        return $this->bookFileName;
    }

    public function setBookFileName(?string $bookFileName): static
    {
        $this->bookFileName = $bookFileName;

        return $this;
    }

    public function getBookFilePath(): ?string
    {
        return $this->bookFilePath;
    }

    public function setBookFilePath(?string $bookFilePath): static
    {
        $this->bookFilePath = $bookFilePath;

        return $this;
    }

    public function getCoverImageName(): ?string
    {
        return $this->coverImageName;
    }

    public function setCoverImageName(?string $coverImageName): static
    {
        $this->coverImageName = $coverImageName;

        return $this;
    }

    public function getCoverImagePath(): ?string
    {
        return $this->coverImagePath;
    }

    public function setCoverImagePath(?string $coverImagePath): static
    {
        $this->coverImagePath = $coverImagePath;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
