<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    // Trait
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Email field can\'t be empty.')]
    #[Assert\Length(min: 5, max: 30,
        minMessage: 'Email shoud have at least {{ limit }} characters.',
        maxMessage: 'Email shoud have no more than {{ limit }} characters.')]
    #[Assert\Email(message: 'Email {{ value }} is not a valid email.')]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Html::class, orphanRemoval: true)]
    private Collection $htmls;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Css::class, orphanRemoval: true)]
    private Collection $csses;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
        $this->htmls = new ArrayCollection();
        $this->csses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Html>
     */
    public function getHtmls(): Collection
    {
        return $this->htmls;
    }

    public function addHtml(Html $html): self
    {
        if (!$this->htmls->contains($html)) {
            $this->htmls->add($html);
            $html->setUser($this);
        }

        return $this;
    }

    public function removeHtml(Html $html): self
    {
        if ($this->htmls->removeElement($html)) {
            // set the owning side to null (unless already changed)
            if ($html->getUser() === $this) {
                $html->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Css>
     */
    public function getCsses(): Collection
    {
        return $this->csses;
    }

    public function addCss(Css $css): self
    {
        if (!$this->csses->contains($css)) {
            $this->csses->add($css);
            $css->setUser($this);
        }

        return $this;
    }

    public function removeCss(Css $css): self
    {
        if ($this->csses->removeElement($css)) {
            // set the owning side to null (unless already changed)
            if ($css->getUser() === $this) {
                $css->setUser(null);
            }
        }

        return $this;
    }
}