<?php

namespace App\Entity;

use App\Repository\ChatonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatonRepository::class)
 */
class Chaton
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Nom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Sterilise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Photo;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="chatons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Categorie;

    /**
     * @ORM\ManyToMany(targetEntity=Proprietaire::class, inversedBy="chatons")
     */
    private $Proprietaire;

    public function __construct()
    {
        $this->Proprietaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function isSterilise(): ?bool
    {
        return $this->Sterilise;
    }

    public function setSterilise(bool $Sterilise): self
    {
        $this->Sterilise = $Sterilise;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(string $Photo): self
    {
        $this->Photo = $Photo;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->Categorie;
    }

    public function setCategorie(?Categorie $Categorie): self
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    /**
     * @return Collection<int, Proprietaire>
     */
    public function getProprietaire(): Collection
    {
        return $this->Proprietaire;
    }

    public function addProprietaire(Proprietaire $proprietaire): self
    {
        if (!$this->Proprietaire->contains($proprietaire)) {
            $this->Proprietaire[] = $proprietaire;
        }

        return $this;
    }

    public function removeProprietaire(Proprietaire $proprietaire): self
    {
        $this->Proprietaire->removeElement($proprietaire);

        return $this;
    }
}