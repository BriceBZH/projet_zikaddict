<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
#[ORM\Table(name: 'artists')]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $deathDate = null;

    #[ORM\Column]
    private ?bool $dead = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $idCountry = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $idMedia = null;

    #[ORM\ManyToMany(targetEntity: Song::class)]
    private Collection $idSong;

    public function __construct()
    {
        $this->idSong = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getDeathDate(): ?\DateTimeInterface
    {
        return $this->deathDate;
    }

    public function setDeathDate(\DateTimeInterface $deathDate): static
    {
        $this->deathDate = $deathDate;

        return $this;
    }

    public function isDead(): ?bool
    {
        return $this->dead;
    }

    public function setDead(bool $dead): static
    {
        $this->dead = $dead;

        return $this;
    }

    public function getIdCountry(): ?Country
    {
        return $this->idCountry;
    }

    public function setIdCountry(?Country $idCountry): static
    {
        $this->idCountry = $idCountry;

        return $this;
    }

    public function getIdMedia(): ?Media
    {
        return $this->idMedia;
    }

    public function setIdMedia(?Media $idMedia): static
    {
        $this->idMedia = $idMedia;

        return $this;
    }

    /**
     * @return Collection<int, Song>
     */
    public function getIdSong(): Collection
    {
        return $this->idSong;
    }

    public function addIdSong(Song $idSong): static
    {
        if (!$this->idSong->contains($idSong)) {
            $this->idSong->add($idSong);
        }

        return $this;
    }

    public function removeIdSong(Song $idSong): static
    {
        $this->idSong->removeElement($idSong);

        return $this;
    }
}
