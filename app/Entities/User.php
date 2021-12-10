<?php


namespace App\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $email;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, name="first_name")
     */
    protected $firstName;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, name="last_name")
     */
    protected $lastName;

    /**
     * @var Account|null
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumn(name="owned_by_account_id", referencedColumnName="id", nullable=false)
     */
    protected $owningAccount;

    /**
     * @var ArrayCollection|Membership[]
     * One User has many members. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Membership", mappedBy="user", fetch="EAGER")
     */
    protected $memberships;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="email_verified_at", nullable=true)
     */
    protected $emailVerifiedAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="updated_at", nullable=false)
     */
    protected $updatedAt;

    public function __construct(?int $id = null) {
        if($id > 0) {
            $this->id = $id;
        }
        $this->memberships          = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return DateTime
     */
    public function getEmailVerifiedAt(): DateTime
    {
        return $this->emailVerifiedAt;
    }

    /**
     * @param DateTime $emailVerifiedAt
     */
    public function setEmailVerifiedAt(DateTime $emailVerifiedAt): void
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    /**
     * @return Account|null
     */
    public function getOwningAccount(): ?Account
    {
        return $this->owningAccount;
    }

    /**
     * @param Account|null $owningAccount
     */
    public function setOwningAccount(?Account $owningAccount): void
    {
        $this->owningAccount = $owningAccount;
    }

    /**
     * @return Membership[]|ArrayCollection
     */
    public function getMemberships()
    {
        return $this->memberships;
    }

    /**
     * @param Membership[]|ArrayCollection $memberships
     */
    public function setMemberships($memberships): void
    {
        $this->memberships = $memberships;
    }


}
