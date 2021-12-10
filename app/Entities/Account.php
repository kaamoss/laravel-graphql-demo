<?php

namespace App\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="title", nullable=false)
     */
    protected $title;

    /**
     * @var User|null
     * An Account has a main user. This is the owning side.
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumn(name="primary_user_id", referencedColumnName="id", nullable=true)
     */
    protected $primaryUser;

    /**
     * @var Membership|null
     */
    protected $primaryMember;

    /**
     * @var Account|null
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumn(name="parent_account_id", referencedColumnName="id", nullable=true)
     */
    protected $parentAccount;

    /**
     * @var ArrayCollection|Account[]
     * @ORM\OneToMany(targetEntity="Account", mappedBy="parentAccount")
     * @ORM\JoinColumn(name="id", referencedColumnName="parent_account_id", nullable=true)
     */
    protected $childAccounts;

    /**
     * @var ArrayCollection|Membership[]
     * One Account has many members. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Membership", mappedBy="account")
     */
    protected $members;

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
        $this->childAccounts    = new ArrayCollection();
        $this->members          = new ArrayCollection();
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return User|null
     */
    public function getPrimaryUser(): ?User
    {
        return $this->primaryUser;
    }

    /**
     * @param User|null $primaryUser
     */
    public function setPrimaryUser(?User $primaryUser): void
    {
        $this->primaryUser = $primaryUser;
    }

    /**
     * @return Membership|null
     */
    public function getPrimaryMember(): ?Membership
    {
        return $this->primaryMember;
    }

    /**
     * @param Membership|null $primaryMember
     */
    public function setPrimaryMember(?Membership $primaryMember): void
    {
        $this->primaryMember = $primaryMember;
    }



    /**
     * @return Account|null
     */
    public function getParentAccount(): ?Account
    {
        return $this->parentAccount;
    }

    /**
     * @param Account|null $parentAccount
     */
    public function setParentAccount(?Account $parentAccount): void
    {
        $this->parentAccount = $parentAccount;
    }

    /**
     * @return Account[]|ArrayCollection
     */
    public function getChildAccounts()
    {
        return $this->childAccounts;
    }

    /**
     * @param Account[]|ArrayCollection $childAccounts
     */
    public function setChildAccounts($childAccounts): void
    {
        $this->childAccounts = $childAccounts;
    }

    /**
     * @return Membership[]|ArrayCollection
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param Membership[]|ArrayCollection $members
     */
    public function setMembers($members): void
    {
        $this->members = $members;
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



}
