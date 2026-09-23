<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\ValueObject\Identification;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $sexe = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $naissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Race $race = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Species $specie = null;

    #[ORM\Column(length: 30, unique: true)]
    private string $identificationData;

    private ?Identification $identification = null;

    public function getIdentification(): ?Identification
    {
        if ($this->identification === null && $this->identificationData !== '') {
            [$type, $numero] = explode(':', $this->identificationData, 2);
            $this->identification = $type === Identification::TYPE_TRANSPONDEUR
                ? Identification::fromTranspondeur($numero)
                : Identification::fromTatouage($numero);
        }
        return $this->identification;
    }

    public function setIdentification(Identification $identification): self
    {
        $this->identification = $identification;
        $this->identificationData = $identification->getType() . ':' . $identification->getNumero();
        return $this;
    }

    public function __construct(String $nom="", bool $sexe=true, \DateTime $date=null)
    {
        $this->nom=$nom;
        $this->sexe=$sexe;
        $this->naissance=$date;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function isSexe(): ?bool
    {
        return $this->sexe;
    }

    public function setSexe(bool $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getNaissance(): ?\DateTime
    {
        return $this->naissance;
    }

    public function setNaissance(?\DateTime $naissance): static
    {
        $this->naissance = $naissance;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getSpecie(): ?Species
    {
        return $this->specie;
    }

    public function setSpecie(?Species $specie): static
    {
        $this->specie = $specie;

        return $this;
    }
}
