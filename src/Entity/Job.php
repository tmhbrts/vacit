<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $icon_filename;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="job")
     */
    private $applications;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

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

    public function getEmployer(): ?User
    {
        return $this->employer;
    }

    public function setEmployer(?User $employer): self
    {
        $this->employer = $employer;

        return $this;
    }

    public function getIconFilename(): ?string
    {
        return $this->icon_filename;
    }

    public function setIconFilename(string $icon_filename): self
    {
        $this->icon_filename = $icon_filename;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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
            $application->setJob($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getJob() === $this) {
                $application->setJob(null);
            }
        }

        return $this;
    }
}