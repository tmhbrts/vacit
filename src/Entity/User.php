<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    /**
     * @ORM\Column(type="text")
     */
    private $bio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture_filename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cv_filename;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="candidate", orphanRemoval=true)
     */
    private $applications;

    public function __construct()
    {
        parent::__construct();
        $this->applications = new ArrayCollection();
        // your own logic
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getPictureFilename(): ?string
    {
        return $this->picture_filename;
    }

    public function setPictureFilename(?string $picture_filename): self
    {
        $this->picture_filename = $picture_filename;

        return $this;
    }

    public function getCvFilename(): ?string
    {
        return $this->cv_filename;
    }

    public function setCvFilename(string $cv_filename): self
    {
        $this->cv_filename = $cv_filename;

        return $this;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setCandidate($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getCandidate() === $this) {
                $application->setCandidate(null);
            }
        }

        return $this;
    }
}

?>
