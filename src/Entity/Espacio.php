<?php

namespace App\Entity;

use App\Repository\EspacioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EspacioRepository::class)
 */
class Espacio
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
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity=Categoria::class, mappedBy="espacio")
     */
    private $Categoria;

    public function __construct()
    {
        $this->Categoria = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nombre;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Categoria>
     */
    public function getCategoria(): Collection
    {
        return $this->Categoria;
    }

    public function addCategorium(Categoria $categorium): self
    {
        if (!$this->Categoria->contains($categorium)) {
            $this->Categoria[] = $categorium;
            $categorium->setEspacio($this);
        }

        return $this;
    }

    public function removeCategorium(Categoria $categorium): self
    {
        if ($this->Categoria->removeElement($categorium)) {
            // set the owning side to null (unless already changed)
            if ($categorium->getEspacio() === $this) {
                $categorium->setEspacio(null);
            }
        }

        return $this;
    }
}
