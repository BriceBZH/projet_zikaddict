<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
#[ORM\Table(name: 'albums')]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $mediaId = null;

    #[ORM\ManyToMany(targetEntity: Format::class)]
    private Collection $idFormat;

    #[ORM\ManyToMany(targetEntity: Song::class)]
    private Collection $idSong;

    public function __construct()
    {
        $this->idFormat = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getMediaId(): ?Media
    {
        return $this->mediaId;
    }

    public function setMediaId(?Media $mediaId): static
    {
        $this->mediaId = $mediaId;

        return $this;
    }

    /**
     * @return Collection<int, Format>
     */
    public function getIdFormat(): Collection
    {
        return $this->idFormat;
    }

    public function addIdFormat(Format $idFormat): static
    {
        if (!$this->idFormat->contains($idFormat)) {
            $this->idFormat->add($idFormat);
        }

        return $this;
    }

    public function removeIdFormat(Format $idFormat): static
    {
        $this->idFormat->removeElement($idFormat);

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
