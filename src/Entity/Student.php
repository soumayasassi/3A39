<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\Column(length: 20)]
    private ?string $nsc = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?Classroom $class = null;

    #[ORM\ManyToMany(targetEntity: Club::class,
        inversedBy: 'students')]
    #[ORM\JoinTable(name:'student_club')]
    #[ORM\JoinColumn(name: "student_id", referencedColumnName: "nsc")]
    #[ORM\InverseJoinColumn(name: "club_id", referencedColumnName: "ref")]
    private Collection $clubs;

    public function __construct()
    {
        $this->clubs = new ArrayCollection();
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNsc(): ?string
    {
        return $this->nsc;
    }

    /**
     * @param string|null $nsc
     */
    public function setNsc(?string $nsc): void
    {
        $this->nsc = $nsc;
    }

    public function getClass(): ?Classroom
    {
        return $this->class;
    }

    public function setClass(?Classroom $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * @return Collection<int, Club>
     */
    public function getClubs(): Collection
    {
        return $this->clubs;
    }

    public function addClub(Club $club): self
    {
        if (!$this->clubs->contains($club)) {
            $this->clubs->add($club);
        }

        return $this;
    }

    public function removeClub(Club $club): self
    {
        $this->clubs->removeElement($club);

        return $this;
    }
}
