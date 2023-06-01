<?php

namespace App\Entity;

use App\Repository\HtmlRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HtmlRepository::class)]
class Html
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Name field can\'t be empty.')]
    #[Assert\Length(min: 3, max: 30,
        minMessage: 'Name shoud have at least {{ limit }} characters.',
        maxMessage: 'Name should have no more than {{ limit }} characters.')]
    private ?string $name = null;

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
}