<?php

namespace App\Entity;

use App\Repository\RealisateurRepository;
use App\Interfaces\FilableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RealisateurRepository::class)
 */
class Realisateur implements FilableInterface
{

    public const FILE_DIR = '/upload/realisateur'; // pour ensuite créer un dossier pour les uploads


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\OneToMany(targetEntity=Film::class, mappedBy="realisateur")
     */
    private $films;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function __construct()
    {
        $this->films = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return Collection|Film[]
     */
    public function getFilms(): Collection
    {
        return $this->films;
    }

    public function addFilm(Film $film): self
    {
        if (!$this->films->contains($film)) {
            $this->films[] = $film;
            $film->setRealisateur($this);
        }

        return $this;
    }

    public function removeFilm(Film $film): self
    {
        if ($this->films->removeElement($film)) {
            // set the owning side to null (unless already changed)
            if ($film->getRealisateur() === $this) {
                $film->setRealisateur(null);
            }
        }

        return $this;
    }

    public function getFullName(): string{
        return $this->getPrenom().' '.$this->getNom();
    }
    
    public function __toString()
    {
        return $this->getFullName();
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function getFileDirectory(): string
    {
        return self::FILE_DIR;
    }
}
