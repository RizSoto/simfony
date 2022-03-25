<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="!! L'activité doit être renseignée!!")
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="⚠ L'adresse doit être renseignée.")
     * @Assert\Regex(pattern="#^[0-9][1-9]{0,2}#", message="!! numéro de rue incorrect!!")
     * @Assert\Regex(pattern="# [0-9]{5}#", message="!! problème avec le code postal!!")
     * @Assert\Regex(pattern="# rue | avenue | boulevard | impasse | allée | place | route | voie #", message="!! Le type de route/voie est incorrect!!")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="!! Le nom doit être renseigné!!")
     * @Assert\Regex(pattern="#^[A-Za-z0-9]{4}#", message="!! Le nom de l'entreprise doit comporter au minimum 4 caractères!!")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank(message="!! L'URL doit être renseignée!!")
     * @Assert\Url(message="!! La saisie doit respectée le format d'une URL!!")
     * @Assert\Regex(pattern="#http:\/\/www\.[A-Za-z0-9]+\.[A-Za-z0-9]{2,4}#", message="!! La saisie doit respectée le format d'une URL !!")
     */
    private $urlSite;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="Entreprise")
     */
    private $entreprises;

    public function __construct()
    {
        $this->entreprises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
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

    public function getUrlSite(): ?string
    {
        return $this->urlSite;
    }

    public function setUrlSite(string $urlSite): self
    {
        $this->urlSite = $urlSite;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getEntreprises(): Collection
    {
        return $this->entreprises;
    }

    public function addEntreprise(Stage $entreprise): self
    {
        if (!$this->entreprises->contains($entreprise)) {
            $this->entreprises[] = $entreprise;
            $entreprise->setEntreprise($this);
        }

        return $this;
    }

    public function removeEntreprise(Stage $entreprise): self
    {
        if ($this->entreprises->removeElement($entreprise)) {
            // set the owning side to null (unless already changed)
            if ($entreprise->getEntreprise() === $this) {
                $entreprise->setEntreprise(null);
            }
        }

        return $this;
    }
}
