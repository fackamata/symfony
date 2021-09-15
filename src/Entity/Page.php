<?php

namespace App\Entity;

use App\Repository\PageRepository;
use App\Interfaces\FilableInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Page implements FilableInterface
{
    public const FILE_DIR = '/upload/page'; // pour ensuite créer un dossier pour les uploads

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $titreOnglet;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $titrePage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     */
    private $texte;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ordre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreOnglet(): ?string
    {
        return $this->titreOnglet;
    }

    public function setTitreOnglet(string $titreOnglet): self
    {
        $this->titreOnglet = $titreOnglet;

        return $this;
    }

    public function getTitrePage(): ?string
    {
        return $this->titrePage;
    }

    public function setTitrePage(string $titrePage): self
    {
        $this->titrePage = $titrePage;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFileDirectory(): string
    {
        return self::FILE_DIR;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(){
        $this->slugalize();
    }
    /**
     * @ORM\PreUpdate
     */
    public function preUpadte(){
        $this->slugalize();
    }

    private function slugalize(): void{
        $slug = strtolower($this->getTitrePage());
        $slug = preg_replace('/[^0-9a-z]+/', '-', $slug);
        $this->setSlug($slug.'-'.uniqid());
    }
}
