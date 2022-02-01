<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 * @UniqueEntity(fields={"galery", "number"}, message="This number is already in use within your gallery.")
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
     * @ORM\ManyToOne(targetEntity=Galery::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Galery $galery;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $path;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Regex(pattern="#^[1-9]+[0-9]*$#", message="Positive number required")
     */
    private ?int $number;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }
}
