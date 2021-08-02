<?php

namespace App\Entity;

use App\Repository\JeuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JeuxRepository::class)
 */
class Jeux
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
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video_path;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couverture_path;

    /**
     * @ORM\Column(type="date")
     */
    private $date_sortie;

    /**
     * @ORM\ManyToMany(targetEntity=Genres::class, inversedBy="jeux")
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity=Developpeurs::class, inversedBy="jeux")
     */
    private $developpeur;

    /**
     * @ORM\ManyToOne(targetEntity=Classifications::class, inversedBy="jeux")
     */
    private $classification;

    /**
     * @ORM\ManyToMany(targetEntity=PlateFormes::class, inversedBy="jeux")
     */
    private $plate_forme;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="jeux")
     */
    private $avis;
    
    private float $noteMoyenne;

    public function __construct()
    {
        $this->genre = new ArrayCollection();
        $this->plate_forme = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVideoPath(): ?string
    {
        return $this->video_path;
    }

    public function setVideoPath(?string $video_path): self
    {
        $this->video_path = $video_path;

        return $this;
    }

    public function getCouverturePath(): ?string
    {
        return $this->couverture_path;
    }

    public function setCouverturePath(?string $couverture_path): self
    {
        $this->couverture_path = $couverture_path;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(\DateTimeInterface $date_sortie): self
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    /**
     * @return Collection|Genres[]
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genres $genre): self
    {
        if (!$this->genre->contains($genre)) {
            $this->genre[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genres $genre): self
    {
        $this->genre->removeElement($genre);

        return $this;
    }

    public function getDeveloppeur(): ?Developpeurs
    {
        return $this->developpeur;
    }

    public function setDeveloppeur(?Developpeurs $developpeur): self
    {
        $this->developpeur = $developpeur;

        return $this;
    }

    public function getClassification(): ?Classifications
    {
        return $this->classification;
    }

    public function setClassification(?Classifications $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * @return Collection|PlateFormes[]
     */
    public function getPlateForme(): Collection
    {
        return $this->plate_forme;
    }

    public function addPlateForme(PlateFormes $plateForme): self
    {
        if (!$this->plate_forme->contains($plateForme)) {
            $this->plate_forme[] = $plateForme;
        }

        return $this;
    }

    public function removePlateForme(PlateFormes $plateForme): self
    {
        $this->plate_forme->removeElement($plateForme);

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setJeux($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getJeux() === $this) {
                $avi->setJeux(null);
            }
        }

        return $this;
    }

    public function getNoteMoyenne(): ?float{
        return $this->noteMoyenne;
    }

    public function setNoteMoyenne($noteMoyenne): ?self{
        $this->noteMoyenne = $noteMoyenne;
        return $this;
    }
}
