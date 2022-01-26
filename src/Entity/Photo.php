<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $link;

    /**
     * @ORM\ManyToOne(targetEntity=Galery::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private Galery $galery;

    /**
     * @ORM\ManyToOne(targetEntity=Photo::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="photo", orphanRemoval=true)
     */
    private $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getGalery(): ?Galery
    {
        return $this->galery;
    }

    public function setGalery(?Galery $galery): self
    {
        $this->galery = $galery;

        return $this;
    }

    public function getPhoto(): ?self
    {
        return $this->photo;
    }

    public function setPhoto(?self $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(self $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setPhoto($this);
        }

        return $this;
    }

    public function removePhoto(self $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getPhoto() === $this) {
                $photo->setPhoto(null);
            }
        }

        return $this;
    }
}
