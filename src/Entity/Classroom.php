<?php

namespace App\Entity;

use App\Repository\ClassroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassroomRepository::class)]
class Classroom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'class', targetEntity: Student::class)]
    private Collection $students;



    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->students2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setClass($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getClass() === $this) {
                $student->setClass(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents2(): Collection
    {
        return $this->students2;
    }

    public function addStudents2(Student $students2): self
    {
        if (!$this->students2->contains($students2)) {
            $this->students2->add($students2);
            $students2->setClassroom($this);
        }

        return $this;
    }

    public function removeStudents2(Student $students2): self
    {
        if ($this->students2->removeElement($students2)) {
            // set the owning side to null (unless already changed)
            if ($students2->getClassroom() === $this) {
                $students2->setClassroom(null);
            }
        }

        return $this;
    }
}
