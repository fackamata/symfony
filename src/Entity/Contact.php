<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sanitaryPass;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSanitaryPass(): ?bool
    {
        return $this->sanitaryPass;
    }

    public function setSanitaryPass(?bool $sanitaryPass): self
    {
        $this->sanitaryPass = $sanitaryPass;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->getFirstname().' '.$this->getName();
    }
}