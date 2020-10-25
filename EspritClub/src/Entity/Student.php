<?php
namespace App\Entity;
use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
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
    private $NSC;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Email;

    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class, inversedBy="student")
     */
    private $classroom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNSC(): ?string
    {
        return $this->NSC;
    }

    public function setNSC(string $NSC): self
    {
        $this->NSC = $NSC;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): self
    {
        $this->Email = $Email;

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
}
